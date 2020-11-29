<?php

namespace App\Entity;

/**
 * Результат методики тестирования по Р. М. Белбину
 */
class UserBelbinProfile
{
    /**
     * Координатор, тип
     * @var int
     */
    public $coordinator = null;

    /**
     * Мотиватор, тип
     * @var int
     */
    public $shaper = null;

    /**
     * Душа команды, тип
     * @var int
     */
    public $teamWorker = null;

    /**
     * Дипломат, тип
     * @var int
     */
    public $resourceInvestigator = null;

    /**
     * Генератор идей, тип
     * @var int
     */
    public $plant = null;

    /**
     * Аналитик, тип
     * @var int
     */
    public $monitorEvaluator = null;

    /**
     * Исполнитель, тип
     * @var int
     */
    public $implementer = null;

    /**
     * Специалист, тип
     * @var int
     */
    public $specialist = null;

    /**
     * Финишер, тип
     * @var int
     */
    public $completerFinisher = null;

}
