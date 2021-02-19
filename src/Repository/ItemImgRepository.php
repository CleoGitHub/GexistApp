<?php

namespace App\Repository;

use App\Entity\ItemImg;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ItemImg|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItemImg|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItemImg[]    findAll()
 * @method ItemImg[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemImgRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemImg::class);
    }

    // /**
    //  * @return ImgItemColor[] Returns an array of ImgItemColor objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ImgItemColor
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
