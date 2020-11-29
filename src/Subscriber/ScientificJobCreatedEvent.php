<?php

namespace App\Subscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\ScientificJob;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ScientificJobCreatedEvent implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['handle', EventPriorities::POST_WRITE],
        ];
    }

    public function handle(ViewEvent $event)
    {
        if (empty($_ENV['API_URL']) || filter_var($_ENV['API_URL'], FILTER_VALIDATE_URL) === false) {
            return;
        }

        $scientificJob = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$scientificJob instanceof ScientificJob || Request::METHOD_POST !== $method) {
            return;
        }

        /* $curlOptions = [
             CURLOPT_RETURNTRANSFER => 1,
             CURLOPT_HEADER => 0,
             CURLOPT_HTTPHEADER => [
                 "Accept: application/json",
             ]
         ];

         $ch = curl_init($_ENV['API_URL']);
         curl_setopt_array($ch, $curlOptions);
         $response = curl_exec($ch);
         curl_close($ch);
         $results = json_decode($response, true);

         if (json_last_error() !== JSON_ERROR_NONE) {
             return;
         }*/
    }
}
