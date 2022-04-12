<?php

namespace App\Repository;

use App\Entity\Suite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Suite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Suite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Suite[]    findAll()
 * @method Suite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Suite::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Suite $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Suite $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Suite[]
     */
    public function findEstablishment($establishment): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.establishment IN (:establishment)')
            ->setParameter('establishment', $establishment)
            ->getQuery()
            ->getResult();
    }

    public function findById($suiteId): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.id LIKE :id')
            ->setParameter('id', $suiteId)
            ->getQuery()
            ->getResult();
    }
}
