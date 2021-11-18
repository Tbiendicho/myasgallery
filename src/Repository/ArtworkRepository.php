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
     * Récupère toutes les informations liées au tvShow demandé
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
     * Récupère toutes les informations liées au tvShow demandé
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
     * Récupère toutes les informations liées au tvShow demandé
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
     * Récupère toutes les informations liées au tvShow demandé
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
     * Récupère toutes les informations liées au tvShow demandé
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


    // /**
    //  * @return Artwork[] Returns an array of Artwork objects
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
    public function findOneBySomeField($value): ?Artwork
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
