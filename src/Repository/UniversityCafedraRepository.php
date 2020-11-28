<?php

namespace App\Repository;

use App\Entity\UniversityCafedra;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UniversityCafedra|null find($id, $lockMode = null, $lockVersion = null)
 * @method UniversityCafedra|null findOneBy(array $criteria, array $orderBy = null)
 * @method UniversityCafedra[]    findAll()
 * @method UniversityCafedra[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UniversityCafedraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UniversityCafedra::class);
    }
}
