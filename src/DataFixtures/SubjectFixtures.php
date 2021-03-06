<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Subject;

class SubjectFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        for ($i=1; $i<=10;$i++){
            $subject = new Subject(); 
            $subject->setName("Subject $i");    
            $subject->setAbbre(1639);

            $manager->persist($subject);
        }
        $manager->flush();
    }
}
