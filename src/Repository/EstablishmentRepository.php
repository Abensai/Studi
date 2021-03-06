<?php

namespace App\Repository;

use App\Entity\Establishment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Establishment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Establishment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Establishment[]    findAll()
 * @method Establishment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EstablishmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Establishment::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Establishment $entity, bool $flush = true): void
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
    public function remove(Establishment $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Establishment[]
     */
    public function firstSix(): array
    {
        return $this->createQueryBuilder('e')
           ->orderBy('e.id', 'DESC')
           ->setMaxResults(6)
           ->getQuery()
           ->getResult();
    }

    /**
     * @return Establishment[]
     */
    public function findById($establishment): array
    {
        return $this->createQueryBuilder('e')
            ->where('e.id LIKE :establishment')
            ->setParameter('establishment', $establishment)
            ->getQuery()
            ->getResult();
    }

    public function getEstateManager($manager): QueryBuilder
    {
        return $this->createQueryBuilder('e')
            ->where('e.user IN (:manager)')
            ->setParameter('manager', $manager);
    }
}
