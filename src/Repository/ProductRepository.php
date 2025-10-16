<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }
public function countByCategory(string $category): int
{
    $query = $this->getEntityManager()->createQuery(
        'SELECT COUNT(p.id)
         FROM App\Entity\Product p
         WHERE p.category = :category'
    )->setParameter('category', $category);

    return $query->getSingleScalarResult();
}
public function findBetweenDates(\DateTime $start, \DateTime $end): array
{
    $query = $this->getEntityManager()->createQuery(
        'SELECT p
         FROM App\Entity\Product p
         WHERE p.createdAt BETWEEN :start AND :end'
    )
    ->setParameter('start', $start)
    ->setParameter('end', $end);

    return $query->getResult();
}


    //    /**
    //     * @return Product[] Returns an array of Product objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Product
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
