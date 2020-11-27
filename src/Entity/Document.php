<?php

namespace App\Entity;

class Document
{
    /** @var int|null */
    protected $id;

    /** @var string|null */
    public $contentUrl;

    public $file;

    /** @var string|null */
    public $filePath;

    /** @var string|null */
    public $fileMimeType;

    /** @var \DateTimeImmutable|null */
    protected $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }
}
