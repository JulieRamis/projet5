<?php

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public function findIngredientByUser($user, $beginAt, $endAt)
    {
        return $this->createQueryBuilder('m')
            ->leftJoin('m.ingredientMenus', 'im')->addSelect('im')
            ->leftJoin('m.user', 'u')->addSelect('u')
            ->where('m.user=:user')->setParameter('user', $user)
            ->andWhere('m.beginAt>=:begin_at')->setParameter('begin_at', $beginAt)
            ->andWhere('m.endAt<=:end_at')->setParameter('end_at', $endAt)
            ->leftJoin('im.ingredient', 'i')->addSelect('i')
            ->select('i.name, SUM(im.quantity) AS quantity_sum')
            ->groupBy('i.name')
            ->getQuery()->getResult();
    }

    public function getOneMenuByUser($id, $user){
        return $this->createQueryBuilder('b')
            ->where('b.id=:id')->setParameter('id',$id)
            ->leftJoin('b.user','u')->addSelect('u')
            ->where('b.user=:$user')->setParameters('user',$user)
            ->getQuery()->getOneOrNullResult();
    }

    // /**
    //  * @return Booking[] Returns an array of Booking objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Booking
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
