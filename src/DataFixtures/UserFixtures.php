<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setNom("jean")
                ->setPrenom('Aubert')
                ->setAge('55')
                ->setEmail("aubert@gmail.com")
                ->setTelephone("0299606645")
                ->setRole('ROLE_USER');
                
            $manager->persist($user);
        }

        $manager->flush();
    }
}
