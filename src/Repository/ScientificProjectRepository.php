<?php

namespace App\Repository;

use App\Entity\ScientificProject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ScientificProject|null find($id, $lockMode = null, $lockVersion = null)
 * @method ScientificProject|null findOneBy(array $criteria, array $orderBy = null)
 * @method ScientificProject[]    findAll()
 * @method ScientificProject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScientificProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ScientificProject::class);
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(ScientificProject $entity)
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }
}
