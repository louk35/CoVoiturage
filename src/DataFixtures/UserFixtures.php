<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setNom("jean")
            ->setPrenom('Aubert')
            ->setAge('55')
            ->setEmail("aubert@gmail.com")
            ->setTelephone("0299606645")
            ->setPassword("abcdef");


        $user2 = new User();
        $user2->setNom("Place")
            ->setPrenom('Louka')
            ->setAge('20')
            ->setEmail("louka.place@univ-nantes.com")
            ->setTelephone("0622945365")
            ->setPassword("123456");


        $user3 = new User();
        $user3->setNom("Kamanda")
            ->setPrenom('Aubin')
            ->setAge('21')
            ->setEmail("kamanda.aubin@univ-nantes.com")
            ->setTelephone("06666666")
            ->setPassword("azertyuiop");


        $manager->persist($user);
        $manager->persist($user2);
        $manager->persist($user3);


        $manager->flush();
    }
}
