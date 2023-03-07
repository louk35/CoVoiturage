<?php

namespace App\DataFixtures;

use App\Entity\Trajet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TrajetFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $trajet1 = new Trajet();
        $trajet1->setLieuDepart('Paris')
               ->setLieuArrive('Marseille')
               ->setDateDepart('2023-04-01 12:00:00')
               ->setDateArrive('2023-04-01 18:00:00')
               ->setPrix('50')
               ->setModelVoiture('Renault Clio')
               ->setNbPlace('3');

        $trajet2 = new Trajet();
        $trajet2->setLieuDepart('Lyon')
               ->setLieuArrive('Toulouse')
               ->setDateDepart('2023-04-02 08:00:00')
               ->setDateArrive('2023-04-02 16:00:00')
               ->setPrix('70')
               ->setModelVoiture('Peugeot 308')
               ->setNbPlace('4');

        $trajet3 = new Trajet();
        $trajet3->setLieuDepart('Nice')
               ->setLieuArrive('Bordeaux')
               ->setDateDepart('2023-04-03 10:00:00')
               ->setDateArrive('2023-04-03 21:00:00')
               ->setPrix('90')
               ->setModelVoiture('Volkswagen Golf')
               ->setNbPlace('2');

        $manager->persist($trajet1);
        $manager->persist($trajet2);
        $manager->persist($trajet3);

        $manager->flush();
    }
}
