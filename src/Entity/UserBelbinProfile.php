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
    public $coordinator;

    /**
     * Мотиватор, тип
     * @var int
     */
    public $shaper;

    /**
     * Душа команды, тип
     * @var int
     */
    public $teamWorker;

    /**
     * Дипломат, тип
     * @var int
     */
    public $resourceInvestigator;

    /**
     * Генератор идей, тип
     * @var int
     */
    public $plant;

    /**
     * Аналитик, тип
     * @var int
     */
    public $monitorEvaluator;

    /**
     * Исполнитель, тип
     * @var int
     */
    public $implementer;

    /**
     * Специалист, тип
     * @var int
     */
    public $specialist;

    /**
     * Финишер, тип
     * @var int
     */
    public $completerFinisher;

}
