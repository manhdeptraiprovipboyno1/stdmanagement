<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Lecturer;

class LecturerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i=1; $i<=10;$i++){
            $lecturer = new Lecturer(); 
            $lecturer->setName("Lecturer $i");    
            $lecturer->setBirthday(\DateTime::createFromFormat('Y-m-d','1995-09-01'));
            $lecturer->setNationality("Vietnam");
            $lecturer->setAvatar("avatar.png");

            $manager->persist($lecturer);
        }
        $manager->flush();
    }
}
