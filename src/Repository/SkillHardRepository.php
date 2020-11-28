<?php

namespace App\Repository;

use App\Entity\SkillHard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SkillHard|null find($id, $lockMode = null, $lockVersion = null)
 * @method SkillHard|null findOneBy(array $criteria, array $orderBy = null)
 * @method SkillHard[]    findAll()
 * @method SkillHard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillHardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SkillHard::class);
    }
}
