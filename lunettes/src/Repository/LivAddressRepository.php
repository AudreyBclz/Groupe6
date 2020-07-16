<?php

namespace App\Repository;

use App\Entity\LivAddress;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LivAddress|null find($id, $lockMode = null, $lockVersion = null)
 * @method LivAddress|null findOneBy(array $criteria, array $orderBy = null)
 * @method LivAddress[]    findAll()
 * @method LivAddress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivAddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LivAddress::class);
    }

    public function livaddress($id)
    {

        $query=$this->createQueryBuilder('l')
            ->select('l')
            ->innerJoin(User::class,'u','WITH','l.id = u.livAddress')
            ->where('u.id=:id')
            ->setParameter('id',$id);
        return $query->getQuery()->getResult();

    }
    // /**
    //  * @return LivAddress[] Returns an array of LivAddress objects
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
    public function findOneBySomeField($value): ?LivAddress
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
