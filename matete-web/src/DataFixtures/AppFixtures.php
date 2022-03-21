<?php

namespace App\DataFixtures;

use App\Entity\Producteur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $producteur = new Producteur();
        $producteur->setMail("jdonet@test.fr");
        $producteur->setMdp("jdonet");
        $producteur->setNom("Donet");
        $producteur->setPrenom("Julien");
        $producteur->setTel("123");
        
        
        
        $manager->persist($producteur);
        $manager->flush();
    }
}
