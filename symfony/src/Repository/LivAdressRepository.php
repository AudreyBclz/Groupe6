<?php

namespace App\Repository;

use App\Entity\LivAdress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LivAdress|null find($id, $lockMode = null, $lockVersion = null)
 * @method LivAdress|null findOneBy(array $criteria, array $orderBy = null)
 * @method LivAdress[]    findAll()
 * @method LivAdress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivAdressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LivAdress::class);
    }

    // /**
    //  * @return LivAdress[] Returns an array of LivAdress objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LivAdress
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
