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

    // findRandom method is able to find a defined number of categories
    public function findRandom($count) {

        $query = $this->createQueryBuilder('c')
            ->orderBy('RAND()')
            ->setMaxResults($count)
            ->getQuery();

        return $query->execute();
    }

    /**
     * Get all informations about one category
     * @return Category
     */
    public function findOneCategoryWithAllInfos(string $slug)
    {
        $entityManager = $this->getEntityManager();

        // We will use the DQL (Doctrine Query Language)
        $query = $entityManager->createQuery(
            'SELECT c, w, a
            FROM App\Entity\Category c
            LEFT JOIN c.artworks w
            LEFT JOIN w.artists a

        -- this parameter will forbid some DQL injections
            WHERE c.slug LIKE :slug'
        )->setParameter('slug', "%" . $slug . "%");

        // returns the selected Category Object
        return $query->getOneOrNullResult();
    }

    /**
     * Get all categories who have a specific slug in a part of their name
     * @return Category
     */
    public function searchCategories(string $slug)
    {
        $entityManager = $this->getEntityManager();

        // We will use the DQL (Doctrine Query Language)
        $query = $entityManager->createQuery(
            'SELECT c, w, a
            FROM App\Entity\Category c
            LEFT JOIN c.artworks w
            LEFT JOIN w.artists a

        -- this parameter will forbid some DQL injections
            WHERE c.slug LIKE :slug'
        )->setParameter('slug', "%" . $slug . "%");

        // returns the selected Category Object
        return $query->getResult();
    }

    /**
     * Get all categories with all informations
     * @return Category[]
     */
    public function findCategoriesWithAllInfos():array
    {
        $entityManager = $this->getEntityManager();

        // We will use the DQL (Doctrine Query Language)
        $query = $entityManager->createQuery(
            'SELECT c, w
            FROM App\Entity\Category c
            LEFT JOIN c.artworks w'
        );

        // returns the selected Category Object
        return $query->getResult();
    }
}
