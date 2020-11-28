<?php

namespace App\Entity;

use App\Exception\ValidationException;
use App\Util\StringUtil;

class Position
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    private $salary = 0;
    private $leader = false;

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
            throw new ValidationException("Field name length from 1 to $maxLen chars", 'name');
        }

        $this->name = $name;

        return $this;
    }

    public function getSalary(): int
    {
        return $this->salary;
    }

    public function setSalary(int $salary): Position
    {
        $this->salary = $salary;

        if ($salary < 0 || $salary > 999999999) {
            throw new ValidationException("Salary is too large", 'salary');
        }

        return $this;
    }

    public function isLeader(): bool
    {
        return $this->leader;
    }

    public function setLeader(bool $leader): Position
    {
        $this->leader = $leader;
        return $this;
    }
}
