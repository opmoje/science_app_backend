<?php


namespace App\Entity;


class ScientificProject
{
    private const TYPES = [
        // Исследование
        'RESEARCH',
        // Проверка гипотезы
        'HYPOTHESIS_TEST',
        // Грантовая работа
        'GRANT_MONETIZED',
        // Диссертация
        'DISSERTATION',
        // Проект, под который хотим подать заявку под грант
        'GRANT_MONETIZED_PERSPECTIVE',
    ];

    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $type;

    /** @var University */
    private $university;

    /** @var UniversityFaculty */
    private $faculty;

    /** @var UniversityCafedra */
    private $cafedra;

    /** @var Science */
    private $science;

    /** @var bool */
    private $public = true;

    /** @var \DateTime */
    private $dateFrom;

    /** @var \DateTime */
    private $dateTo;

    /** @var array */
    //TODO: коллекция сущности или роли
    private $personnelRequest = [];

    /** @var SkillHard[]  */
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

}
