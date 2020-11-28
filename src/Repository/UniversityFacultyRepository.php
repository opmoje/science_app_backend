<?php

namespace App\Repository;

use App\Entity\UniversityFaculty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UniversityFaculty|null find($id, $lockMode = null, $lockVersion = null)
 * @method UniversityFaculty|null findOneBy(array $criteria, array $orderBy = null)
 * @method UniversityFaculty[]    findAll()
 * @method UniversityFaculty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UniversityFacultyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UniversityFaculty::class);
    }
}
