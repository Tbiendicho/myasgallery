<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

        /**
     * Récupère toutes les informations liées au tvShow demandé
     * @return Category
     */
    public function findOneCategoryWithAllInfos(string $slug): Category
    {
        $entityManager = $this->getEntityManager();

        // We will use the DQL (Doctrine Query Language)
        $query = $entityManager->createQuery(
            'SELECT c, w, a
            FROM App\Entity\Category c
            JOIN c.artworks w
            JOIN w.artists a

        -- this parameter will forbid some DQL injections
            WHERE c.slug = :slug'
        )->setParameter('slug', $slug);

        // returns the selected Category Object
        return $query->getOneOrNullResult();
    }

    /**
     * Récupère toutes les informations liées au tvShow demandé
     * @return Category[]
     */
    public function findCategoriesWithAllInfos():array
    {
        $entityManager = $this->getEntityManager();

        // We will use the DQL (Doctrine Query Language)
        $query = $entityManager->createQuery(
            'SELECT c, w
            FROM App\Entity\Category c
            JOIN c.artworks w'
        );

        // returns the selected Category Object
        return $query->getResult();
    }

    // /**
    //  * @return Category[] Returns an array of Category objects
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
    public function findOneBySomeField($value): ?Category
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
