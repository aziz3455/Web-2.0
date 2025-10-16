<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }
    public function countRomanceBooks(): int
{
    $query = $this->getEntityManager()->createQuery(
        'SELECT COUNT(b.id)
         FROM App\Entity\Book b
         WHERE b.categorie = :categorie'
    )->setParameter('categorie', 'Romance');

    return $query->getSingleScalarResult();
}

public function findBooksBetweenDates(\DateTime $dateStart, \DateTime $dateEnd): array
{
    $query = $this->getEntityManager()->createQuery(
        'SELECT b
         FROM App\Entity\Book b
         WHERE b.datePublication BETWEEN :start AND :end'
    )
    ->setParameter('start', $dateStart)
    ->setParameter('end', $dateEnd);

    return $query->getResult();
}


    //    /**
    //     * @return Book[] Returns an array of Book objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Book
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
