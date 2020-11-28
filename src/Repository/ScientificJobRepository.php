<?php

namespace App\Repository;

use App\Entity\ScientificJob;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ScientificJob|null find($id, $lockMode = null, $lockVersion = null)
 * @method ScientificJob|null findOneBy(array $criteria, array $orderBy = null)
 * @method ScientificJob[]    findAll()
 * @method ScientificJob[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScientificJobRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ScientificJob::class);
    }
}
