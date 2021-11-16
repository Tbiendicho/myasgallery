<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function findRandom($count) {

        $query = $this->createQueryBuilder('e')
            ->orderBy('RAND()')
            ->setMaxResults($count)
            ->getQuery();

        return $query->execute();
    }

    /**
     * Récupère toutes les informations liées au tvShow demandé
     * @return Event
     */
    public function findOneEventWithAllInfos(string $slug)
    {
        $entityManager = $this->getEntityManager();

        // We will use the DQL (Doctrine Query Language)
        $query = $entityManager->createQuery(
            'SELECT e, w, a
            FROM App\Entity\Event e
            JOIN e.artworks w
            JOIN e.artists a

        -- this parameter will forbid some DQL injections
            WHERE e.slug LIKE :slug OR e.country LIKE :slug'
        )->setParameter('slug', "%" . $slug . "%");

        // returns the selected Artwork Object

        return $query->getOneOrNullResult();
    }

        /**
     * Récupère toutes les informations liées au tvShow demandé
     * @return Event
     */
    public function searchEvents(string $slug)
    {
        $entityManager = $this->getEntityManager();

        // We will use the DQL (Doctrine Query Language)
        $query = $entityManager->createQuery(
            'SELECT e, w, a
            FROM App\Entity\Event e
            JOIN e.artworks w
            JOIN e.artists a

        -- this parameter will forbid some DQL injections
            WHERE e.slug LIKE :slug OR e.country LIKE :slug'
        )->setParameter('slug', "%" . $slug . "%");

        // returns the selected Artwork Object

        return $query->getResult();
    }

    /**
     * Récupère toutes les informations liées au tvShow demandé
     * @return Event[]
     */
    public function findEventsWithAllInfos():array
    {
        $entityManager = $this->getEntityManager();

        // We will use the DQL (Doctrine Query Language)
        $query = $entityManager->createQuery(
            'SELECT e
            FROM App\Entity\Event e'
        );

        // returns the selected Artwork Object
        return $query->getResult();
    }

    /**
     * Récupère toutes les informations liées au tvShow demandé
     * @return Event[]
     */
    public function findEventsByDate():array
    {
        $entityManager = $this->getEntityManager();

        // We will use the DQL (Doctrine Query Language)
        $query = $entityManager->createQuery(
            'SELECT e
            FROM App\Entity\Event e
            ORDER BY e.date ASC'
            );

        // returns the selected Artwork Object
        return $query->getResult();
    }

    // /**
    //  * @return Event[] Returns an array of Event objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
