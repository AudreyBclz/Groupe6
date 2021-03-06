<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Gender;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findByGender($gender)
    {
        $query=$this->createQueryBuilder('p')
            ->select('p')
            ->innerJoin(Gender::class,'g','WITH','p.gender = g.id')
            ->where('g.nameGender = :gender')
            ->orWhere('g.nameGender = :uni')
            ->setParameters(['gender'=>$gender,'uni'=>"Unisexe"]);

        return $query->getQuery()->getResult();
    }

    public function findKid()
    {
        $query=$this->createQueryBuilder('p')
            ->select('p')
            ->innerJoin(Gender::class,'g','WITH','p.gender = g.id')
            ->where('g.nameGender = :gender')
            ->setParameters(['gender'=>'Enfant']);

        return $query->getQuery()->getResult();
    }

    public function findByCat($category)
    {
        $query=$this->createQueryBuilder('p')
            ->select('p')
            ->innerJoin(Category::class,'c','WITH','p.category = c.id')
            ->where('c.nameCategory = :cat')
            ->setParameter('cat',$category);

        return $query->getQuery()->getResult();
    }
    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
