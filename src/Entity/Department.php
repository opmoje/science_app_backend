<?php

namespace App\Entity;

use App\Exception\ValidationException;
use App\Util\StringUtil;

class Department
{
    /** @var int */
    private $id;
    /** @var string */
    private $name;

    /**
     * @throws ValidationException
     */
    public function __construct(string $name)
    {
        $this->setName($name);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @throws ValidationException
     */
    public function setName($name): self
    {
        $len = StringUtil::getLength($name);
        $maxLen = 255;

        if ($len < 1 || $len > $maxLen) {
            throw new ValidationException("First name length from 1 to $maxLen chars", 'name');
        }

        $this->name = $name;

        return $this;
    }
}
