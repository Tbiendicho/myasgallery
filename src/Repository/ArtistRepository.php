<?php

namespace App\Repository;

use App\Entity\Artist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Artist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artist[]    findAll()
 * @method Artist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artist::class);
    }

    // findRandom method is able to find a defined number of artists
    public function findRandom($count) {

        $query = $this->createQueryBuilder('a')
            ->orderBy('RAND()')
            ->setMaxResults($count)
            ->getQuery();

        return $query->execute();
    }

    /**
     * Get all informations about one artist
     * @return Artist
     */
    public function findOneArtistWithAllInfos(string $slug)
    {
        $entityManager = $this->getEntityManager();

        // We will use the DQL (Doctrine Query Language)
        $query = $entityManager->createQuery(
            'SELECT a, w
            FROM App\Entity\Artist a
            LEFT JOIN a.artworks w

        -- this parameter will forbid some DQL injections
            WHERE a.slug LIKE :slug'
        )->setParameter('slug', "%" . $slug . "%");

        // returns the selected Artwork Object
        return $query->getOneOrNullResult();
    }

    /**
     * Get all artists who have a specific slug in a part of their name
     * @return Artist
     */
    public function searchArtists(string $slug)
    {
        $entityManager = $this->getEntityManager();

        // We will use the DQL (Doctrine Query Language)
        $query = $entityManager->createQuery(
            'SELECT a, w
            FROM App\Entity\Artist a
            LEFT JOIN a.artworks w

        -- this parameter will forbid some DQL injections
            WHERE a.slug LIKE :slug'
        )->setParameter('slug', "%" . $slug . "%");

        // returns the selected Artist Object
        return $query->getResult();
    }

    /**
     * Get all artists with all informations
     * @return Artist[]
     */
    public function findArtistsWithAllInfos():array
    {
        $entityManager = $this->getEntityManager();

        // We will use the DQL (Doctrine Query Language)
        $query = $entityManager->createQuery(
            'SELECT a
            FROM App\Entity\Artist a'
        );

        // returns the selected Artist's array Objects
        return $query->getResult();
    }
}
