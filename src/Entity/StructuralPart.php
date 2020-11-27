<?php

namespace App\Entity;


class StructuralPart
{
    /** @var University */
    private $university;

    /** @var UniversityFaculty */
    private $faculty;

    /** @var UniversityCafedra */
    private $cafedra;

    public function __construct(University $university, UniversityFaculty $faculty, UniversityCafedra $cafedra)
    {
        $this->university = $university;
        $this->faculty = $faculty;
        $this->cafedra = $cafedra;
    }

    public function getUniversity(): University
    {
        return $this->university;
    }

    public function getFaculty(): UniversityFaculty
    {
        return $this->faculty;
    }

    public function getCafedra(): UniversityCafedra
    {
        return $this->cafedra;
    }
}
