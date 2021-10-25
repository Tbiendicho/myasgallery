<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Artist;
use App\Entity\Artwork;
use App\Entity\Category;
use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $entityManager): void
    {

        // creating a new variable faker for generating random values
        $faker = Factory::create('fr_FR');

        // generating a list of random artists with faker
        $artistsList = [];
        for ($artistNumber = 0; $artistNumber < 10; $artistNumber++) {
            $artist = new Artist();

        // preparing the database
            $entityManager->persist($artist);

            $artist->setName($faker->name());
            $artist->setBiography($faker->text(500));
            $artist->setCountry($faker->country());
            $artist->setPhoto($faker->image(null, 640, 480));

            // add the fake data in the $artistsList table
            $artistsList[] = $artist;
        }

        $artworkList = [];
         for ($artworkNumber = 0; $artworkNumber < 50; $artworkNumber++) {
             $artwork = new Artwork();
 
             // preparing the database
             $entityManager->persist($artwork);
 
             $artwork->setTitle($faker->title());
             $artwork->setPicture($faker->image(null, 640, 480));
             $artwork->setHeight($faker->numberBetween(10, 200));
             $artwork->setWidth($faker->numberBetween(10, 200));
             $artwork->setDepth($faker->numberBetween(10, 200));
             $artwork->setDescription($faker->text(5));

             // get random artist
             $artistForArtwork = $faker->randomElements($artistsList, '1');

             // add random artist in artists_id column
             foreach ($artistForArtwork as $currentArtist)
             {
                 $artwork->setArtists($currentArtist);
             }

             // add the fake data in the $artworkList table
             $artworkList[] = $artwork;
         }

         // generating a list of random category with faker
         $categoryList = [];
         for ($categoryNumber = 0; $categoryNumber < 5; $categoryNumber++) {
             $category = new Category();
 
             // preparing the database
             $entityManager->persist($category);
 
             $category->setName($faker->words(1, true));

             // add the fake data in the $artworkList table
             $categoryList[] = $category;
         }

        $addressesList = [];
        for ($addressNumber = 0; $addressNumber < 10; $addressNumber++) {
            $address = new Address();

            // preparing the database
            $entityManager->persist($address);

            $address->setRoadNumber($faker->numberBetween(0, 200));
            $address->setRoadName($faker->address());
            $address->setRoadName2($faker->address());
            $address->setZipCode($faker->randomNumber(5, true));
            $address->setTown($faker->city());
            $address->setCountry($faker->country());

            // add the fake data in the $eventsList table
            $addressesList[] = $address;
        }

        // generating a list of random events with faker
        $eventsList = [];
        for ($eventsNumber = 0; $eventsNumber < 10; $eventsNumber++) {
            $event = new Event();

            // preparing the database
            $entityManager->persist($event);

            $event->setName($faker->sentence(5));
            $event->setInformation($faker->text(500));
            $event->setDate($faker->dateTimeBetween('now', '+1 year'));
            $event->setLocalisation($faker->randomFloat(7, 0, 100));
            $event->setLink($faker->url());

            // add a random address and associate it
            $addressOfEvent = $faker->randomElements($addressesList, '1');

            foreach($addressOfEvent as $currentAddress) {
                $event->setAddresses($currentAddress);
            }

            // add the fake data in the $eventsList table
            $eventsList[] = $event;
        }

        // updating the database
        $entityManager->flush();
        
    }
    
}
