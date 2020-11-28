<?php


namespace App\Entity;


use App\Exception\ValidationException;
use App\Util\StringUtil;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class ScientificProject
{
    private const TYPES = [
        // Исследование
        'RESEARCH',
        // Проверка гипотезы
        'HYPOTHESIS_TEST',
        // Диссертация
        'DISSERTATION',
        // Грантовая работа
        'GRANT_MONETIZED',
        // Проект, под который хотим подать заявку под грант
        'GRANT_MONETIZED_PERSPECTIVE',
    ];

    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $type;

    /**
     * Структурная единица (Университет, Факультет, Кафедра)
     * @var StructuralPart
     */
    private $structuralPart;

    /** @var Science */
    private $science;

    /** @var bool */
    private $public = true;

    /** @var \DateTime */
    private $dateFrom;

    /** @var \DateTime */
    private $dateTo;

    /**
     * Необходимые позиции на проект
     * @var Position[]
     */
    private $neededPositions = [];

    /** @var SkillHard[]  */
    private $neededHardSkills = [];

    private $budget = 0;

    /*
     * Кого нужно нам это исполнитель и руководитель и нужны компетенции. Также исполнитель
     *
     */

    /**
     * Источник(и) финансирования, пример:
     * Бортник
     * Потанин
     * РФФИ
     * @var string
     */
    private $budgetSource = '';


    public function __construct(
        string $name,
        string $type,
        UniversityCafedra $cafedra,
        Science $science,
        \DateTime $dateFrom,
        \DateTime $dateTo
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->setStructuralPart($cafedra);
        $this->science = $science;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->neededHardSkills = new ArrayCollection();
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

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        if (!in_array($type, self::TYPES)) {
            throw new \LogicException(
                "Not allowed type, it must be one of: " . implode(', ', self::TYPES)
            );
        }

        $this->type = $type;
        return $this;
    }

    public function getUniversity(): University
    {
        return $this->structuralPart->getUniversity();
    }

    public function getFaculty(): UniversityFaculty
    {
        return $this->structuralPart->getFaculty();
    }

    public function getCafedra(): UniversityCafedra
    {
        return $this->structuralPart->getCafedra();
    }

    public function getStructuralPart(): StructuralPart
    {
        return $this->structuralPart;
    }

    public function setStructuralPart(UniversityCafedra $cafedra): self
    {
        $structuralPart = new StructuralPart(
            $cafedra->getUniversity(),
            $cafedra->getFaculty(),
            $cafedra
        );

        return $this;
    }

    public function getScience(): Science
    {
        return $this->science;
    }

    public function setScience(Science $science): self
    {
        $this->science = $science;
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

    public function getBudgetSource(): string
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
}
