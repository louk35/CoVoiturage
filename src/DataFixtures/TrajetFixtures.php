<?php

namespace App\DataFixtures;

use App\Entity\Trajet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Time;


class TrajetFixtures extends Fixture
{
       public function load(ObjectManager $manager)
       {
              $trajet1 = new Trajet();
              $trajet1->setLieuDepart('Paris')
                     ->setLieuArrive('Marseille')
                     ->setDateDepart(new \DateTime('+30 days'))
                     ->setDateArrive(new \DateTime('+30 days'))
                     ->setPrix('50')
                     ->setModelVoiture('Renault Clio')
                     ->setNbPlace('3')
                     ->setDescription('CCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCC');

              $trajet2 = new Trajet();
              $trajet2->setLieuDepart('Lyon')
                     ->setLieuArrive('Toulouse')
                     ->setDateDepart(new \DateTime('+30 days'))
                     ->setDateArrive(new \DateTime('+30 days'))
                     ->setPrix('70')
                     ->setModelVoiture('Peugeot 308')
                     ->setNbPlace('4')
                     ->setDescription('BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB');

              $trajet3 = new Trajet();
              $trajet3->setLieuDepart('Nice')
                     ->setLieuArrive('Bordeaux')
                     ->setDateDepart(new \DateTime('+30 days'))
                     ->setDateArrive(new \DateTime('+30 days'))
                     ->setPrix('90')
                     ->setModelVoiture('Volkswagen Golf')
                     ->setNbPlace('2')
                     ->setDescription('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA');

              $manager->persist($trajet1);
              $manager->persist($trajet2);
              $manager->persist($trajet3);

              $manager->flush();
       }
}
