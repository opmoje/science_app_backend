<?php

namespace App\Entity;

use App\Exception\ValidationException;
use App\Util\StringUtil;

/**
 * изучаемая наука
 */
class Science
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $code;

    /**
     * @throws ValidationException
     */
    public function __construct(string $name, string $code)
    {
        $this->setName($name);
        $this->setCode($code);
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
    public function setName(string $name): self
    {
        $len = StringUtil::getLength($name);
        $maxLen = 100;

        if ($len < 1 || $len > $maxLen) {
            throw new ValidationException("Science name length from 1 to $maxLen chars", 'name');
        }

        $this->name = $name;
        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        if (!preg_match('/^(\d{1,2})(?:\.\d{1,2})?(?:\.\d{1,2})?$/', $code)) {
            throw new ValidationException("Science code is invalid", 'code');

        }

        $this->code = $code;
        return $this;
    }
}
