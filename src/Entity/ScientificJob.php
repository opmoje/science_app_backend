<?php

namespace App\Entity;

use App\Exception\ValidationException;
use App\Util\StringUtil;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Научный труд
 */
class ScientificJob
{
    private const TYPES = [
        // Публикация
        'PUBLICATION',
        // Конференция
        'CONFERENCE',
        // Диссертация
        'DISSERTATION',
        // Патент
        'PATENT'
    ];

    private const STATUSES = ['IN_WORK', 'DECLINED', 'DECLINED_PERMANENT', 'PUBLISHED'];

    /** @var int */
    private $id;

    /** @var string */
    private $type;

    /** @var string */
    private $status = 'PENDING';

    /** @var User[] */
    private $authors;

    /** @var string */
    private $name;

    /** @var \DateTimeImmutable */
    private $publicationDate;

    /**
     * @throws ValidationException
     */
    public function __construct(
        string $name,
        string $type,
        \DateTimeImmutable $publicationDate,
        string $link,
        ArrayCollection $authors
    ) {
        $this->setType($type);
        $this->setName($name);
        $this->publicationDate = $publicationDate;
        $this->setLink($link);
        $this->authors = $authors;
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Collection|User[]
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function setAuthors(array $authors): self
    {
        $this->authors = new ArrayCollection();

        foreach ($authors as $author) {
            if (!$this->authors->contains($author)) {
                $this->authors[] = $author;
            }
        }

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        if (!in_array($type, self::TYPES)) {
            throw new \LogicException(
                "Not allowed type, it must be one of: " . implode(', ', self::TYPES)
            );
        }

        $this->type = $type;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        if (!in_array($status, self::STATUSES)) {
            throw new \LogicException(
                "Not allowed status, it must be one of: " . implode(', ', self::STATUSES)
            );
        }

        $this->status = $status;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @throws ValidationException
     */
    public function setName(string $name): self
    {
        $len = StringUtil::getLength($name);
        $maxLen = 255;

        if ($len < 1 || $len > $maxLen) {
            throw new ValidationException("Name length from 1 to $maxLen", 'name');
        }

        return $this;
    }

    public function getPublicationDate(): \DateTimeImmutable
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(\DateTimeImmutable $publicationDate): self
    {
        $this->publicationDate = $publicationDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @throws ValidationException
     */
    public function setLink(string $link): self
    {
        if (filter_var($link, FILTER_VALIDATE_URL) === false) {
            throw new ValidationException('Incorrect link url', 'link');
        }

        $this->link = $link;
        return $this;
    }

    public function setFile(Document $file): self
    {
        $this->file = $file;
        return $this;
    }
}
