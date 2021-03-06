<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

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
    public function findallWithLimit($limit): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.publishdate')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findByName($product): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.name LIKE :keyproduct')
            ->setParameter( 'keyproduct', "%$product%")
            ->orderBy('p.name')
            ->getQuery()
            ->getResult();
    }
    public function findByNameAndCategory($product, $category)
    {
        return $this->createQueryBuilder('p')
            ->where('p.category LIKE :keycategory')
            ->setParameter( 'keycategory', $category)
            ->andwhere('p.name LIKE :keyproduct')
            ->setParameter( 'keyproduct', "%$product%")
            ->orderBy('p.name')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
    public function findByCategory($category)
    {
        return $this->createQueryBuilder('p')
            ->where('p.category LIKE :keycategory')
            ->setParameter( 'keycategory', $category)
            ->orderBy('p.name')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}
