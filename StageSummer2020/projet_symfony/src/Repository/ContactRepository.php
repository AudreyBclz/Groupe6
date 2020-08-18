<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    public function findSend($isSend,$isDel)
    {
        if($isSend===0 && $isDel===0)
        {
            $query=$this->createQueryBuilder('c')
                ->select('c')
                ->where('c.fullName != :name')
                ->andWhere('c.isDeleted = 0')
                ->setParameter('name','Areliann');
            return $query->getQuery()->getResult();
        }
        elseif($isSend===0 && $isDel===1)
        {
            $query = $this->createQueryBuilder('c')
                ->select('c')
                ->where('c.fullName != :name')
                ->andWhere('c.isDeleted = 1')
                ->setParameter('name', 'Areliann');
            return $query->getQuery()->getResult();
        }
        elseif ($isSend===1 && $isDel===0)
        {

            $query=$this->createQueryBuilder('c')
                ->select('c')
                ->where('c.fullName = :name')
                ->andWhere('c.isDeleted = 0')
                ->setParameter('name','Areliann');
            return $query->getQuery()->getResult();
        }
        else
        {
            $query=$this->createQueryBuilder('c')
                ->select('c')
                ->where('c.fullName = :name')
                ->andWhere('c.isDeleted = 1')
                ->setParameter('name','Areliann');
            return $query->getQuery()->getResult();
        }
    }

    public function delBin($id)
    {
        return $this->createQueryBuilder('c')
                ->delete()
                ->where('c.id = :id')
                ->setParameter('id',$id)
                ->getQuery()
                ->getResult();

    }

    public function search($valeur)
    {
        $formatDate='/^[0-9]{2}-[0-9]{2}-[0-9]{4}$/';
        $formatDate2='/^[0-9]{2}-[0-9]{2}$/';
        if(preg_match($formatDate,$valeur))
        {
            $valeur=substr($valeur,6,4).'-'.substr($valeur,3,2).'-'.substr($valeur,8,2);
        }
        if(preg_match($formatDate2,$valeur))
        {
            $valeur=substr($valeur,3,2).'-'.substr($valeur,0,2);
        }
        return $this->createQueryBuilder('c')
            ->select('c')
            ->where('c.fullName LIKE :key')
            ->orWhere('c.email LIKE :key')
            ->orWhere('c.subject LIKE :key')
            ->orWhere('c.content LIKE :key')
            ->orWhere('c.date LIKE :key')
            ->setParameter('key','%'.$valeur.'%')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Contact[] Returns an array of Contact objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Contact
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
