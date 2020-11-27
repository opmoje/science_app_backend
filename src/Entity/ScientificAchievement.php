<?php

namespace App\Entity;

use App\Exception\ValidationException;
use App\Util\StringUtil;

class ScientificAchievement
{
    private const TYPES = [
        'PUBLICATION',
        'CONFERENCE',
        'THESIS',
        'PATENT'
    ];

    /** @var int */
    private $id;

    /** @var User */
    private $author;

    /** @var string */
    private $type;

    /** @var string */
    private $name;

    /** @var string */
    private $link;

    /** @var \DateTimeImmutable */
    private $publicationDate;

    /** @var Document|null */
    private $file = null;

    /**
     * @throws ValidationException
     */
    public function __construct(
        string $name,
        string $type,
        \DateTimeImmutable $publicationDate,
        string $link,
        User $author
    ) {
        $this->setType($type);
        $this->setName($name);
        $this->publicationDate = $publicationDate;
        $this->setLink($link);
        $this->author = $author;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthor(User $author): self
    {
        $this->author = $author;
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
