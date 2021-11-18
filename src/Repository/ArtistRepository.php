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

    public function findRandom($count) {

        $query = $this->createQueryBuilder('a')
            ->orderBy('RAND()')
            ->setMaxResults($count)
            ->getQuery();

        return $query->execute();
    }

    /**
     * Récupère toutes les informations liées au tvShow demandé
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
     * Récupère toutes les informations liées au tvShow demandé
     * @return Artist
     */
    public function searchArtists(string $slug)
    {
        $entityManager = $this->getEntityManager();

        // We will use the DQL (Doctrine Query Language)
        $query = $entityManager->createQuery(
            'SELECT a, w
            FROM App\Entity\Artist a
            JOIN a.artworks w

        -- this parameter will forbid some DQL injections
            WHERE a.slug LIKE :slug'
        )->setParameter('slug', "%" . $slug . "%");

        // returns the selected Artwork Object
        return $query->getResult();
    }

    /**
     * Récupère toutes les informations liées au tvShow demandé
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

        // returns the selected Artwork Object
        return $query->getResult();
    }

    public function findArtistByName(string $query)
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->like('p.name', ':query'),
                    $qb->expr()->isNotNull('p.createdAt')
                )
            )
            ->setParameter('query', '%' . $query . '%')
        ;
        return $qb
            ->getQuery()
            ->getResult();
    }






    // /**
    //  * @return Artist[] Returns an array of Artist objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Artist
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
