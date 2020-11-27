<?php

namespace App\Entity;

use App\Exception\ValidationException;

class UserContact
{
    /** @var string */
    private $phone = null;

    /** @var string */
    private $email = null;

    /** @var string */
    private $vk = null;

    /** @var string */
    private $facebook = null;

    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @throws ValidationException
     */
    public function setPhone(string $phone): self
    {
        if (!empty($phone)) {
            $phone = preg_replace('/\s|-/', '', $phone);

            if (!preg_match('/\+\d{1,3}\d{10}/', $phone)) {
                throw new ValidationException('Phone is incorrect', 'phone');
            }

            $this->phone = $phone;
        }

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @throws ValidationException
     */
    public function setEmail(string $email): self
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new ValidationException('Incorrect email', 'email');
        }

        $this->email = $email;
        return $this;
    }

    public function getVk(): string
    {
        return $this->vk;
    }

    /**
     * @throws ValidationException
     */
    public function setVk(string $vk): self
    {
        if (
            filter_var($vk, FILTER_VALIDATE_URL) === false
            || !preg_match('/^http[s]?:\/\/(?:www\.)?vk\.com$/', $vk)
        ) {
            throw new ValidationException('Incorrect vk.com url', 'vk');
        }

        $this->vk = $vk;
        return $this;
    }

    public function getFacebook(): string
    {
        return $this->facebook;
    }

    /**
     * @throws ValidationException
     */
    public function setFacebook(string $facebook): self
    {
        if (
            filter_var($facebook, FILTER_VALIDATE_URL) === false
            || !preg_match('/^http[s]?:\/\/(?:www\.)?vk\.com$/', $facebook)
        ) {
            throw new ValidationException('Incorrect vk.com url', 'vk');
        }

        $this->facebook = $facebook;
        return $this;
    }
}
