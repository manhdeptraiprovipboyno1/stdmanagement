<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Student;

class StudentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i=1; $i<=10;$i++){
            $student = new Student(); 
            $student->setName("Student $i");    
            $student->setBirthday(\DateTime::createFromFormat('Y-m-d','2001-09-01'));
            $student->setNationality("Vietnam");
            $student->setAvatar("avatar.png");

            $manager->persist($student);
        }
        $manager->flush();
    }
}
