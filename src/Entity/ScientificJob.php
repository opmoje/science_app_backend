<?php

namespace App\Entity;

use App\Exception\ValidationException;
use App\Util\StringUtil;

/**
 * Научный труд
 */
class ScientificJob
{
    private const STATUSES = ['IN_WORK', 'DECLINED', 'DECLINED_PERMANENT', 'PUBLISHED'];

    /** @var int */
    private $id;

    /** @var string */
    private $type;

    /** @var string */
    private $status = 'PENDING';

    /** @var User */
    private $author;

    /** @var string */
    private $name;

    /** @var \DateTimeImmutable */
    private $publicationDate;

    /** @var string */
    private $link;

    /** @var int  */
    private $citedCount = 0;

    /** @var string  */
    private $aggregationType = '';


    /**
     * @throws ValidationException
     */
    public function __construct(
        string $name,
        string $type,
        \DateTimeImmutable $publicationDate,
        User $author,
        string $link
    ) {
        $this->setType($type);
        $this->setName($name);
        $this->publicationDate = $publicationDate;
        $this->author = $author;
        $this->author->increaseScientificJobsTotal();
        $this->setLink($link);
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
        $len = StringUtil::getLength($type);
        $maxLen = 100;

        if ($len < 1 || $len > $maxLen) {
            throw new ValidationException("Type length from 1 to $maxLen", 'type');
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
        $maxLen = 1024;

        if ($len < 1 || $len > $maxLen) {
            throw new ValidationException("Name length from 1 to $maxLen", 'name');
        }

        $this->name = $name;

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

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        if (filter_var($link, FILTER_VALIDATE_URL) === false) {
            throw new ValidationException('Incorrect work link', 'link');
        }

        $this->link = $link;
        return $this;
    }

    public function setFile(Document $file): self
    {
        $this->file = $file;
        return $this;
    }

    public function getCitedCount(): int
    {
        return $this->citedCount;
    }

    public function setCitedCount(int $citedCount): self
    {
        $this->citedCount = $citedCount;
        return $this;
    }

    public function getAggregationType(): string
    {
        return $this->aggregationType;
    }

    public function setAggregationType(string $aggregationType): self
    {
        $this->aggregationType = $aggregationType;
        return $this;
    }
}
