<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\ClassM;

class ClassMFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        for ($i=1; $i<=10;$i++){
            $class = new ClassM(); 
            $class->setName("Class $i");    
            $class->setFloor(3);

            $manager->persist($class);
        }
        $manager->flush();
    }
}
