<?php

namespace App\DataFixtures;

use App\Entity\Driver;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $driver1 = new Driver();
        $driver1->setName('Adam');
        $driver1->setSurname('Adamski');

        $driver2 = new Driver();
        $driver2->setName('Bob');
        $driver2->setSurname('Bobowski');

        $driver3 = new Driver();
        $driver3->setName('Cesar');
        $driver3->setSurname('Cesarski');

        $driver4 = new Driver();
        $driver4->setName('Derek');
        $driver4->setSurname('Derecki');

        $driver5 = new Driver();
        $driver5->setName('Evan');
        $driver5->setSurname('Evanski');

        $manager->persist($driver1);
        $manager->persist($driver2);
        $manager->persist($driver3);
        $manager->persist($driver4);
        $manager->persist($driver5);
        
        $manager->flush();
    }
}
