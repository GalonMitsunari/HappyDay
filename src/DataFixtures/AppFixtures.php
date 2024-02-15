<?php
// src/DataFixtures/AppFixtures.php

namespace App\DataFixtures;

use App\Entity\Birthday;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Créer quelques anniversaires de test
        $birthday1 = new Birthday();
        $birthday1->setNom('Doe');
        $birthday1->setPrenom('John');
        $birthday1->setDateAnniversaire(new \DateTime('1990-01-15'));
        $manager->persist($birthday1);

        $birthday2 = new Birthday();
        $birthday2->setNom('Smith');
        $birthday2->setPrenom('Jane');
        $birthday2->setDateAnniversaire(new \DateTime('1985-05-20'));
        $manager->persist($birthday2);

        // Enregistrer les données dans la base de données
        $manager->flush();
    }
}
