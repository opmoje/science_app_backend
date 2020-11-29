<?php

namespace App\Entity;

use App\Exception\ValidationException;
use App\Util\StringUtil;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    private const ROLES = [
        'ROLE_ADMIN',
        'ROLE_ASPIRANT',
        'ROLE_PROFESSOR',
        'ROLE_HEAD_DEPARTMENT',
        'ROLE_PERSONAL',
        'ROLE_STALKER' //TODO: check if this role really needed
    ];

    /** @var int */
    private $id;

    /** @var string */
    private $email;

    private $password;

    /** @var array */
    private $roles = [];

    /** @var string */
    private $displayName;

    /** @var University */
    private $university;

    /**
     * Должность
     * @var Position
     */
    private $position = null;

    /**
     * Отдел @var Department
     */
    private $department = null;

    /** Контакты @var UserContact|null */
    private $contacts = null;

    /**
     * Научные достижения
     * @var ScientificAchievement[]
     */
    private $scientificAchievements = [];

    /**
     * Научные деятельность
     * @var ScientificJob[]
     */
    private $scientificJobs = [];

    /**
     * Хордовые скилы @var SkillHard[]
     */
    private $hardSkills = [];

    /** Софтовые скилы @var SkillSoft[] */
    private $softSkills = [];

    /**
     * Профиль по Белбину
     * @var UserBelbinProfile|null
     */
    private $profileByBelbin = null;

    private $embeddingVector = null;

    /** @var bool */
    private $searchable = true;

    /**
     * @throws ValidationException
     */
    public function __construct(
        string $email,
        string $password,
        string $displayName,
        University $university
    ) {
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setDisplayName($displayName);
        $this->setUniversity($university);
        // initialise empty collections:
        $this->scientificAchievements = new ArrayCollection();
        $this->hardSkills = new ArrayCollection();
        $this->softSkills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->email;
    }

    public function getEmail(): ?string
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

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password): self
    {
        if (empty($password)) {
            throw new ValidationException('Password cannot be empty', 'password');
        }

        $this->password = $password;

        return $this;
    }



    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @throw \LogicException
     */
    public function setRoles(array $roles): self
    {
        while (!empty($roles)) {
            $role = array_shift($roles);
            if (!in_array($role, self::ROLES)) {
                throw new \LogicException(
                    "Not allowed role, it must be one of: " . implode(', ', self::ROLES)
                );
            }

            if (!in_array($role, $this->roles)) {
                $this->roles[] = $role;
            }
        }

        return $this;
    }

    public function getDisplayName()
    {
        return $this->displayName;
    }

    public function setDisplayName(string $displayName): self
    {
        $len = StringUtil::getLength($displayName);

        if ($len < 1 || $len > 100) {
            throw new ValidationException("First name length from 1 to 100 chars", 'displayName');
        }

        $this->displayName = $displayName;
        return $this;
    }

    public function getUniversity(): University
    {
        return $this->university;
    }

    public function setUniversity(University $university): self
    {
        $this->university = $university;
        return $this;
    }

    public function getPosition(): ?Position
    {
        return $this->position;
    }

    public function setPosition(Position $position): self
    {
        $this->position = $position;
        return $this;
    }

    public function getDepartment(): Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department = null): self
    {
        $this->department = $department;
        return $this;
    }

    public function getContacts(): ?UserContact
    {
        return $this->contacts;
    }

    public function setContacts(?UserContact $contacts): self
    {
        $this->contacts = $contacts;
        return $this;
    }

    /**
     * @return Collection|ScientificAchievement[]
     */
    public function getScientificAchievements(): Collection
    {
        return $this->scientificAchievements;
    }

    public function setScientificAchievements(array $scientificAchievements): self
    {
        foreach ($this->scientificAchievements as $achievement) {
            $achievement->setAuthor(null);
        }

        $this->scientificAchievements = new ArrayCollection();

        foreach ($scientificAchievements as $achievement) {
            if (!$this->scientificAchievements->contains($achievement)) {
                $this->scientificAchievements[] = $achievement;
                $achievement->setAuthor($this);
            }
        }

        return $this;
    }

    public function getHardSkills()
    {
        return $this->hardSkills;
    }

    public function setHardSkills(array $hardSkills): self
    {
        $this->hardSkills = new ArrayCollection();

        foreach ($hardSkills as $skill) {
            if (!$this->hardSkills->contains($skill)) {
                $this->hardSkills[] = $skill;
            }
        }

        return $this;
    }

    public function getSoftSkills(): array
    {
        return $this->softSkills;
    }

    public function setSoftSkills(array $softSkills): self
    {
        $this->softSkills = new ArrayCollection();

        foreach ($softSkills as $skill) {
            if (!$this->softSkills->contains($skill)) {
                $this->softSkills[] = $skill;
            }
        }

        return $this;
    }

    public function getProfileByBelbin(): ?UserBelbinProfile
    {
        return $this->profileByBelbin;
    }

    public function setProfileByBelbin(UserBelbinProfile $profileByBelbin): self
    {
        $this->profileByBelbin = $profileByBelbin;
        return $this;
    }

    public function isSearchable(): bool
    {
        return $this->searchable;
    }

    public function setSearchable(bool $searchable): self
    {
        $this->searchable = $searchable;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
