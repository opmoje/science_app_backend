<?php

namespace App\Entity;

use App\Exception\ValidationException;
use App\Util\StringUtil;

class UniversityFaculty
{
    /** @var int */
    private $id;
    /** @var string */
    private $name;
    /** @var University */
    private $university;

    /**
     * @throws ValidationException
     */
    public function __construct(string $name, University $university)
    {
        $this->setName($name);
        $this->university = $university;
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

        if ($len < 1 || $len > 100) {
            throw new ValidationException("First name length from 1 to 255 chars", 'name');
        }

        $this->name = $name;

        return $this;
    }

    public function getUniversity(): University
    {
        return $this->university;
    }
}
