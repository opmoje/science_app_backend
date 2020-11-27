<?php

namespace App\Entity;

use App\Exception\ValidationException;
use App\Util\StringUtil;

class UniversityCafedra
{
    /** @var int */
    private $id;
    /** @var string */
    private $name;
    /** @var University */
    private $university;
    /** @var UniversityFaculty */
    private $faculty;

    /**
     * @throws ValidationException
     */
    public function __construct(string $name, University $university, UniversityFaculty $faculty)
    {
        $this->setName($name);
        $this->university = $university;
        $this->faculty = $faculty;
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
            throw new ValidationException("Field name length from 1 to $maxLen chars", 'name');
        }

        $this->name = $name;

        return $this;
    }

    public function getUniversity(): University
    {
        return $this->university;
    }

    public function getFaculty(): UniversityFaculty
    {
        return $this->faculty;
    }
}
