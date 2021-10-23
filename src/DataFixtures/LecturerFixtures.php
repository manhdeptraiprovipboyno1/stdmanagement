<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LecturerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i=1; $i<=10;$i++){
            $lecturer = new Lecturer(); 
            $lecturer->setName("Author $i");    
        }
        $manager->flush();
    }
}
