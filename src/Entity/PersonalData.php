<?php

namespace App\Entity;

use App\Exception\ValidationException;
use App\Util\StringUtil;

class PersonalData
{
    /** @var string */
    private $firstName;

    /** @var string */
    private $middleName;

    /** @var string */
    private $lastName;

    /**
     * @throws ValidationException
     */
    public function __construct(
        string $firstName,
        string $middleName,
        string $lastName
    ) {
        $this->setFirstName($firstName);
        $this->setMiddleName($middleName);
        $this->setLastName($lastName);
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @throws ValidationException
     */
    public function setFirstName(string $firstName): self
    {
        $len = StringUtil::getLength($firstName);

        if ($len < 1 || $len > 100) {
            throw new ValidationException("First name length from 1 to 100 chars", 'firstName');
        }

        $this->firstName = $firstName;
        return $this;
    }

    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    /**
     * @throws ValidationException
     */
    public function setMiddleName(string $middleName): self
    {
        $len = StringUtil::getLength($middleName);

        if ($len < 1 || $len > 100) {
            throw new ValidationException("Middle name length from 1 to 100 chars", 'middleName');
        }

        $this->middleName = $middleName;
        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @throws ValidationException
     */
    public function setLastName(string $lastName): self
    {
        $len = StringUtil::getLength($lastName);

        if ($len < 1 || $len > 100) {
            throw new ValidationException("Last name length from 1 to 100 chars", 'lastName');
        }

        $this->lastName = $lastName;
        return $this;
    }
}
