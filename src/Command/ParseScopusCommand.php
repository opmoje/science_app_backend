<?php

namespace App\Command;

use App\Entity\ScientificJob;
use App\Entity\University;
use App\Entity\User;
use App\Entity\UserContact;
use App\Exception\ValidationException;
use App\Repository\ScientificJobRepository;
use App\Repository\UniversityRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParseScopusCommand extends Command
{
    protected static $defaultName = 'app:parse:scopus';

    //private const API_URL_TPL = 'https://api.elsevier.com/content/search/scopus?type=json&query={query}&apiKey=3cdbc2961ec5129c099690633bf6879c';
    private const API_URL_TPL = 'https://api.elsevier.com/content/search/scopus?start=700&count=25&query={query}&apiKey=3cdbc2961ec5129c099690633bf6879c';

    private $em;
    private $userRepository;
    private $universityRepository;
    private $scientificJobRepository;

    public function __construct(
        EntityManagerInterface $em,
        UserRepository $userRepository,
        UniversityRepository $universityRepository,
        ScientificJobRepository $scientificJobRepository
    ) {
        $this->em = $em;
        $this->userRepository = $userRepository;
        $this->universityRepository = $universityRepository;
        $this->scientificJobRepository = $scientificJobRepository;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Run parser of scientific jobs from scopus.com.')
            ->addArgument('query', InputArgument::REQUIRED, 'Search query');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        set_time_limit(0);

        $query = urlencode($input->getArgument('query'));
        $url = str_replace('{query}', $query, self::API_URL_TPL);
        $output->writeln("Load $url");
        $results = $this->loadPage($url);

        if (empty($results['search-results']) || empty($results['search-results']['entry'])) {
            $output->writeln("Empty search results");
            return 0;
        }

        $scopusResults = $this->parsePage($results['search-results']['entry']);
        $this->saveResults($scopusResults);

        $nextPage = !empty($results['search-results']['link'])
            ? $this->extractNextPage($results['search-results']['link'])
            : null;

        while (!empty($nextPage)) {
            $output->writeln("Load $nextPage");
            $results = $this->loadPage($nextPage);
            $scopusResults = $this->parsePage($results['search-results']['entry']);
            $this->saveResults($scopusResults);

            $nextPage = !empty($results['search-results']['link'])
                ? $this->extractNextPage($results['search-results']['link'])
                : null;
        }


        return 1;
    }

    private function saveResults(array $scopusResults)
    {
        $this->em->getConnection()->connect();

        while (!empty($scopusResults)) {
            $result = array_shift($scopusResults);

            if (
                empty($result['title'])
                || empty($result['author'])
                || empty($result['university'])
                || empty($result['link'])
                || empty($result['subtype'])
                || empty($result['publishedDate'])
            ) {
                continue;
            }

            $dummyEmail = $this->generateEmail($result['author']);
            $author = $this->userRepository->findOneBy(['email' => $dummyEmail]);

            if (empty($author)) {
                $university = $this->universityRepository->findOneBy(['name' => $result['university']]);

                if (empty($university)) {
                    try {
                        $university = new University($result['university']);
                        $this->em->persist($university);
                    } catch (ValidationException $e) {
                        dump($e);
                        die;
                        continue;
                    }
                }

                try {

                    $author = new User($dummyEmail, 'dummy', $result['author'], $university);
                    $dummyLogin = $this->clearString($result['author']);
                    $contact = new UserContact();

                    if (mt_rand(0, 1) === 1) {
                        $contact->setEmail($dummyEmail);
                    }

                    if (mt_rand(0, 1) === 1) {
                        $randomPhone = '+7' . mt_rand(1000000000, 9999999999);
                        $contact->setPhone($randomPhone);
                    }

                    if (mt_rand(0, 2) === 2) {
                        $contact->setFacebook('https://facebook.com/' . $dummyLogin);
                    }

                    if (mt_rand(0, 5) === 5) {
                        $contact->setVk('https://vk.com/' . $dummyLogin);
                    }

                    $author->setContacts($contact);
                    $this->em->persist($author);

                } catch (ValidationException $e) {
                    dump($e);
                    die;
                    continue;
                }
            }

            try {
                $scientificJob = new ScientificJob(
                    $result['title'],
                    $result['subtype'],
                    $result['publishedDate'],
                    $author,
                    $result['link']
                );
                $scientificJob->setAggregationType($result['aggregationType']);
                $scientificJob->setCitedCount($result['citedCount']);
                $this->em->persist($scientificJob);

            } catch (ValidationException $e) {
                dump($e);
                die;
                continue;
            }

            $this->em->transactional(function ($em) {
                $em->flush();
            });
            $this->em->getConnection()->close();
        }
    }

    private function loadPage(string $url): array
    {
        $curlOptions = [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
            ]
        ];

        $ch = curl_init($url);
        curl_setopt_array($ch, $curlOptions);
        $response = curl_exec($ch);
        curl_close($ch);

        $results = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Json is not valid');
        }

        return $results;
    }

    private function parsePage($entries): array
    {
        $results = [];
        $k = 0;

        while (!empty($entries)) {
            $entry = array_shift($entries);

            if (empty($entry['dc:title']) || empty($entry['dc:creator'])) {
                continue;
            }

            $k++;
            $entry['dc:title'] = trim(strip_tags($entry['dc:title']));
            $results[$k] = [
                'title' => $entry['dc:title'],
                'shortDescription' => '',
                'keywords' => [],
                'citedCount' => $entry['citedby-count'],
                'publishedDate' => new \DateTimeImmutable($entry['prism:coverDate']),
                'author' => $entry['dc:creator'],
                'university' => (!empty($entry['affiliation'][0]['affilname']))
                    ? $entry['affiliation'][0]['affilname']
                    : null,
                'subtype' => $entry['subtypeDescription'],
                'aggregationType' => $entry['prism:aggregationType'],
                'link' => '',
            ];

            while (!empty($entry['link'])) {
                $link = array_shift($entry['link']);
                if (
                    $link['@ref'] === 'scopus'
                    && $link['@_fa'] === 'true'
                    && !empty($link['@href'])
                    && filter_var($link['@href'], FILTER_VALIDATE_URL) !== false
                ) {
                    $results[$k]['link'] = $link['@href'];
                    break;
                }
            }

            /*if (!empty($results[$k]['link'])) {
                $results[$k] = array_merge($results[$k], $this->parseMaterialPage($results[$k]['link']));
            }*/
        }

        return $results;
    }

    private function extractNextPage(array $links): ?string
    {
        $nextPage = null;

        while (!empty($links)) {
            $item = array_shift($links);

            if (
                $item['@ref'] === 'next'
                && !empty($item['@href'])
                && filter_var($item['@href'], FILTER_VALIDATE_URL) !== false
            ) {
                $nextPage = $item['@href'];
                break;
            }
        }

        return $nextPage;
    }

    private function generateEmail(string $name): string
    {
        $mailProviders = ['ya.ru', 'yandex.ru', 'mail.ru', 'mail.com', 'yahoo.com', 'gmail.com'];
        $randomKey = array_rand($mailProviders);
        $name = $this->clearString($name);

        return $name . '@' . $mailProviders[$randomKey];
    }

    private function clearString(string $str)
    {
        $str = trim(strip_tags($str));
        $str = preg_replace('/[^a-z0-9]/i', '', $str);
        return $str;
    }

    private function parseMaterialPage(string $url): array
    {
        $result = [
            'shortDescription' => '',
            'keywords' => [],
        ];

        $curlOptions = [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPHEADER => [
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
                'Accept-Language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
                'Connection: keep-alive',
                'Upgrade-Insecure-Requests: 1',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:83.0) Gecko/20100101 Firefox/83.0',
            ],
            CURLOPT_FAILONERROR => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_COOKIEJAR => '',
            CURLOPT_VERBOSE => false,
        ];

        $ch = curl_init($url);
        curl_setopt_array($ch, $curlOptions);
        $response = curl_exec($ch);

        return $result;
    }


}
