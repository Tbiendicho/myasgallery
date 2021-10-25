<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $entityManager): void
    {
        $faker = Factory::create('fr_FR');

        $artistsList = [];
        for ($artistNumber = 0; $artistNumber < 11; $artistNumber++) {
            $artist = new Artist();
            $entityManager->persist($artist);

            $artist->setName($faker->name());
            $artist->setBiography($faker->text(500));
            $artist->setCountry($faker->word());
            $artist->setPhoto($faker->image(null, 640, 480));

            $artistsList[] = $artist;
        }

        $entityManager->flush();
        
    }
    
}
