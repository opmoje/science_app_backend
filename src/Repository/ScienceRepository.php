<?php

namespace App\Repository;

use App\Entity\Science;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Science|null find($id, $lockMode = null, $lockVersion = null)
 * @method Science|null findOneBy(array $criteria, array $orderBy = null)
 * @method Science[]    findAll()
 * @method Science[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScienceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Science::class);
    }
}
