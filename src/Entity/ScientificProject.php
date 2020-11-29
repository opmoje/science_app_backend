<?php


namespace App\Entity;


use App\Exception\ValidationException;
use App\Util\StringUtil;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class ScientificProject
{
    /** @var int */
    private $id;

    /**
     * Кто создал проект
     * @var User
     */
    private $user;

    /**
     * Приглашенные участники
     * @var User[]
     */
    private $participants = [];

    /** @var string */
    private $name;

    /** @var string */
    private $description;

    /** @var string */
    private $type;

    /** @var bool */
    private $public = true;

    /** @var \DateTime */
    private $dateFrom;

    /** @var \DateTime */
    private $dateTo;

    /** @var int */
    private $participantsCountNeeded = 2;

    /**
     * Необходимые позиции на проект
     * @var Position[]
     */
    private $neededPositions = [];

    /** @var SkillHard[] */
    private $neededHardSkills = [];

    private $budget = 0;

    /**
     * Источник(и) финансирования, пример:
     * Бортник
     * Потанин
     * РФФИ
     * @var string
     */
    private $budgetSource = '';

    /** @var User[] */
    private $recommendedUsers = [];

    /**
     * @throws ValidationException
     */
    public function __construct(
        string $name,
        string $description,
        string $type,
        User $user,
        \DateTime $dateFrom,
        \DateTime $dateTo
    ) {
        $this->setName($name);
        $this->setDescription($description);
        $this->setType($type);
        $this->user = $user;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->participants = new ArrayCollection();
        $this->neededHardSkills = new ArrayCollection();
        $this->recommendedUsers = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $len = StringUtil::getLength($name);
        $maxLen = 255;

        if ($len < 1 || $len > $maxLen) {
            throw new ValidationException("Field name length from 1 to $maxLen chars", 'name');
        }

        $this->name = $name;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @throws ValidationException
     */
    public function setDescription(string $description): self
    {
        $len = StringUtil::getLength($description);
        $maxLen = 65535;

        if ($len < 1 || $len > $maxLen) {
            throw new ValidationException("Description length from 1 to $maxLen chars", 'description');
        }

        $this->description = $description;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        //TODO: restrict by user role
        $this->user = $user;
        return $this;
    }

    public function getParticipantsCountNeeded(): int
    {
        return $this->participantsCountNeeded;
    }

    public function setParticipantsCountNeeded(int $participantsCountNeeded): self
    {
        if ($participantsCountNeeded < 2 || $participantsCountNeeded > 99) {
            throw new ValidationException(
                "participants count is invalid: min 2, max 99", 'participantsCountNeeded'
            );
        }

        $this->participantsCountNeeded = $participantsCountNeeded;
        return $this;
    }

    public function getParticipants()
    {
        return $this->participants;
    }

    public function setParticipants(array $participants): self
    {
        $this->participants = new ArrayCollection();

        foreach ($participants as $participant) {
            if (!$this->participants->contains($participant)) {
                $this->participants[] = $participant;
            }
        }

        return $this;
    }

    public function isPublic(): bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): self
    {
        $this->public = $public;
        return $this;
    }

    public function getDateFrom(): \DateTime
    {
        return $this->dateFrom;
    }

    public function setDateFrom(\DateTime $dateFrom): self
    {
        $this->dateFrom = $dateFrom;
        return $this;
    }

    public function getDateTo(): \DateTime
    {
        return $this->dateTo;
    }

    public function setDateTo(\DateTime $dateTo): self
    {
        $this->dateTo = $dateTo;
        return $this;
    }

    /**
     * @return Collection|Position[]
     */
    public function getNeededPositions(): array
    {
        return $this->neededPositions;
    }

    public function setNeededPositions(array $neededPositions): self
    {
        $this->neededPositions = new ArrayCollection();

        foreach ($neededPositions as $position) {
            if (!$this->neededPositions->contains($position)) {
                $this->neededPositions[] = $position;
            }
        }

        return $this;
    }

    /**
     * @return Collection|SkillHard[]
     */
    public function getNeededHardSkills(): Collection
    {
        return $this->neededHardSkills;
    }

    public function setNeededHardSkills(array $neededHardSkills): self
    {
        $this->neededHardSkills = new ArrayCollection();

        foreach ($neededHardSkills as $skill) {
            if (!$this->neededHardSkills->contains($skill)) {
                $this->neededHardSkills[] = $skill;
            }
        }

        return $this;
    }

    public function getBudget(): int
    {
        return $this->budget;
    }

    public function setBudget(int $budget): self
    {
        $this->budget = $budget;

        if ($budget < 0 || $budget > 999999999) {
            throw new ValidationException("Budget is too large", 'budget');
        }

        return $this;
    }

    public function getBudgetSource(): ?string
    {
        return $this->budgetSource;
    }

    public function setBudgetSource(string $budgetSource): self
    {
        $len = StringUtil::getLength($budgetSource);
        $maxLen = 100;

        if ($len < 1 || $len > $maxLen) {
            throw new ValidationException("Budget source length from 1 to $maxLen chars", 'budgetSource');
        }

        $this->budgetSource = $budgetSource;
        return $this;
    }

    public function getRecommendedUsers(): Collection
    {
        return $this->recommendedUsers;
    }

    public function setRecommendedUsers(array $recommendedUsers): self
    {
        $this->recommendedUsers = new ArrayCollection();

        foreach ($recommendedUsers as $user) {
            if (!$this->recommendedUsers->contains($user)) {
                $this->recommendedUsers[] = $user;
            }
        }

        return $this;
    }
}
