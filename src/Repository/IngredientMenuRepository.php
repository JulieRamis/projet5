<?php

namespace App\Repository;

use App\Entity\IngredientMenu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method IngredientMenu|null find($id, $lockMode = null, $lockVersion = null)
 * @method IngredientMenu|null findOneBy(array $criteria, array $orderBy = null)
 * @method IngredientMenu[]    findAll()
 * @method IngredientMenu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngredientMenuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IngredientMenu::class);
    }

    // /**
    //  * @return IngredientMenu[] Returns an array of IngredientMenu objects
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
    public function findOneBySomeField($value): ?IngredientMenu
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
