<?php

namespace App\Repository;

use App\Entity\Artwork;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Artwork|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artwork|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artwork[]    findAll()
 * @method Artwork[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtworkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artwork::class);
    }

    // findRandom method is able to find a defined number of artworks
    public function findRandom($count) {

        $query = $this->createQueryBuilder('w')
            ->orderBy('RAND()')
            ->setMaxResults($count)
            ->getQuery();

        return $query->execute();
    }

    public function findRandomArtworkByCategory($count, $slug) {

        $query = $this->createQueryBuilder('w')
            ->innerJoin('w.categories', 'c')
            ->where('c.slug = :slug')
            ->setParameter('slug', $slug)
            ->orderBy('RAND()')
            ->setMaxResults($count)
            ->getQuery();

        return $query->execute();
    }

    /**
     * Get all informations about one artwork
     * @return Artwork
     */
    public function findOneArtworkWithAllInfos(string $slug)
    {
        $entityManager = $this->getEntityManager();

        // We will use the DQL (Doctrine Query Language)
        $query = $entityManager->createQuery(
            'SELECT w, a, c
            FROM App\Entity\Artwork w
            LEFT JOIN w.artists a
            LEFT JOIN w.categories c

        -- this parameter will forbid some DQL injections
            WHERE w.slug LIKE :slug'
        )->setParameter('slug', "%" . $slug . "%");

        // returns the selected Artwork Object
        return $query->getOneOrNullResult();
    }

        /**
     * Get all artworks which have a specific slug in a part of their title
     * @return Artwork
     */
    public function searchArtworks(string $slug)
    {
        $entityManager = $this->getEntityManager();

        // We will use the DQL (Doctrine Query Language)
        $query = $entityManager->createQuery(
            'SELECT w, a, c
            FROM App\Entity\Artwork w
            LEFT JOIN w.artists a
            LEFT JOIN w.categories c

        -- this parameter will forbid some DQL injections
            WHERE w.slug LIKE :slug'
        )->setParameter('slug', "%" . $slug . "%");

        // returns the selected Artwork Object
        return $query->getResult();
    }

    /**
     * Get all artworks with all informations
     * @return Artwork[]
     */
    public function findArtworksWithAllInfos():array
    {
        $entityManager = $this->getEntityManager();

        // We will use the DQL (Doctrine Query Language)
        $query = $entityManager->createQuery(
            'SELECT w, a
            FROM App\Entity\Artwork w
            LEFT JOIN w.artists a'
        );

        // returns the selected Artwork Object
        return $query->getResult();
    }

    /**
     * Get all artworks from one category
     * @return Artwork[]
     */
    public function findArtworksFromOneCategory(string $slug):array
    {
        $entityManager = $this->getEntityManager();

        // We will use the DQL (Doctrine Query Language)
        $query = $entityManager->createQuery(
            'SELECT w, a, c
            FROM App\Entity\Artwork w
            LEFT JOIN w.artists a
            LEFT JOIN w.categories c

        -- this parameter will forbid some DQL injections
            WHERE c.slug = :slug'
        )->setParameter('slug', $slug);

        // returns the selected Artwork Object
        return $query->getResult();
    }

    /**
     * Get a defined number of artworks from one category
     * @return Artwork[]
     */
    public function findArtworksFromCategoryWithLimit($limit, $slug):array
    {
        // We will use the DQL (Doctrine Query Language)
        $query = $this->createQueryBuilder('w')
            ->innerJoin('w.categories', 'c')
            ->where('c.slug = :slug')
            ->setParameter('slug', $slug)
            ->setMaxResults($limit)
            ->getQuery();

        return $query->execute();
    }
}
