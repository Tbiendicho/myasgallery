<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Artist;
use App\Entity\Artwork;
use App\Entity\Category;
use App\Entity\Event;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher) {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $entityManager): void
    {
        $categoryList = [];
        $artistsList = [];
        $artworkList = [];
        $eventsList = [];


        // creating a new variable faker for generating random values
        $faker = Factory::create('fr_FR');

        // generating a list of random artists with faker

        for ($artistNumber = 0; $artistNumber < 10; $artistNumber++) {
            $artist = new Artist();

        // preparing the database
            $entityManager->persist($artist);

            $artist->setName($faker->name());
            $artist->setBiography($faker->text(500));
            $artist->setCountry($faker->country());
            $imageId = $faker->numberBetween(1, 500);
            $artist->setPhoto("https://picsum.photos/id/{$imageId}/200/300");

            // add the fake data in the $artistsList table
            $artistsList[] = $artist;
        }

        // generating a list of random category with faker
        for ($categoryNumber = 0; $categoryNumber < 5; $categoryNumber++) {
            $category = new Category();

            // preparing the database
            $entityManager->persist($category);

            $category->setName($faker->words(1, true));

            // add the fake data in the $categoryList table
            $categoryList[] = $category;
        }

        // generating a list of random events with faker

        for ($eventsNumber = 0; $eventsNumber < 10; $eventsNumber++) {
            $event = new Event();

            // preparing the database
            $entityManager->persist($event);

            $event->setName($faker->sentence(5));
            $event->setInformation($faker->text(500));
            $event->setDate($faker->dateTimeBetween('now', '+1 year'));
            $event->setLatitude($faker->latitude(-90, 90));
            $event->setLongitude($faker->longitude(-180, 180));
            $event->setLink($faker->url());
            $event->setRoadNumber($faker->numberBetween(0, 200));
            $event->setRoadName($faker->address());
            $event->setRoadName2($faker->address());
            $event->setZipCode($faker->randomNumber(5, true));
            $event->setTown($faker->city());
            $event->setCountry($faker->country());

            // add the fake data in the $eventsList table
            $eventsList[] = $event;
        }

        for ($artworkNumber = 0; $artworkNumber < 50; $artworkNumber++) {
             $artwork = new Artwork();
 
             // preparing the database
             $entityManager->persist($artwork);
 
             $artwork->setTitle($faker->words(2, true));
             $imageId = $faker->numberBetween(1, 500);
             $artwork->setPicture("https://picsum.photos/id/{$imageId}/200/300");
             $artwork->setHeight($faker->numberBetween(10, 200));
             $artwork->setWidth($faker->numberBetween(10, 200));
             $artwork->setDepth($faker->numberBetween(10, 200));
             $artwork->setDescription($faker->text(5));

             // get random artist
             $artistForArtwork = $faker->randomElement($artistsList);

             // add random artist in artists_id column

            $artwork->setArtists($artistForArtwork);

            // get random category
            $categoryForArtwork = $faker->randomElement($categoryList);

            // add random category in category_id column

            $artwork->addCategory($categoryForArtwork);

            // get random event
            $eventForArtwork = $faker->randomElement($eventsList);

            // add random event in event_id column

            $artwork->addEvent($eventForArtwork);

            // add the fake data in the $artworkList table
            $artworkList[] = $artwork;

         }

        $adminUser = new User();
        $entityManager->persist($adminUser);
        $adminUser->setRoles(['ROLE_ADMIN']);
        $adminUser->setEmail('admin@myasg.com');
        $adminUser->setPassword($this->passwordHasher->hashPassword($adminUser, 'admin'));

        $user = new User();
        $entityManager->persist($user);
        $user->setRoles(['ROLE_USER']);
        $user->setEmail('user@myasg.com');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'user'));

        // updating the database
        $entityManager->flush();
        
    }
    
}
