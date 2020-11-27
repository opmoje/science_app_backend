<?php


namespace App\Entity;


class ScientificProject
{
    private const TYPES = [
        'PUBLICATION', 'CONFERENCE', 'THESIS', 'PATENT'
    ];

    /** @var int */
    private $id;

    /** @var string */
    private $type;

    /** @var string */
    private $name;

    /** @var \DateTimeImmutable */
    private $publicationDate;

    public function __construct()
    {

    }
}
