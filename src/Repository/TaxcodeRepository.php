<?php

namespace App\Repository;

use App\Entity\Taxcode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Taxcode|null find($id, $lockMode = null, $lockVersion = null)
 * @method Taxcode|null findOneBy(array $criteria, array $orderBy = null)
 * @method Taxcode[]    findAll()
 * @method Taxcode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaxcodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Taxcode::class);
    }

    // /**
    //  * @return Taxcode[] Returns an array of Taxcode objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Taxcode
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
