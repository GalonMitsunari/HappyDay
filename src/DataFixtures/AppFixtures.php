<?php
// src/DataFixtures/AppFixtures.php

namespace App\DataFixtures;

use App\Entity\Birthday;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create(); // Faker permet de générer des noms et prénoms aléatoires

        for ($i = 0; $i < 20; $i++) {
            $birthday = new Birthday();
            $birthday->setNom($faker->lastName);
            $birthday->setPrenom($faker->firstName); 
            $randomDate = $this->generateRandomDate(); 
            $birthday->setDateAnniversaire($randomDate);
            $manager->persist($birthday);
        }

        $manager->flush();
    }

    private function generateRandomDate(): \DateTime
    {
        $startDate = new \DateTime('1950-01-01');
        $endDate = new \DateTime();
        $randomTimestamp = mt_rand($startDate->getTimestamp(), $endDate->getTimestamp());
        $randomDate = new \DateTime();
        $randomDate->setTimestamp($randomTimestamp);
        return $randomDate;
    }
}