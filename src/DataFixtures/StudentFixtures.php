<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class StudentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $student = new Student();
        $student->setName('John Doe');
        $student->setBirthDay(new \DateTime('now'));
        $student->setEmail('tuna@gmail.com');
        $student->setPhone('+123456789');
        $student->setStudentId('123456789');
        $student->setImage('https://via.placeholder.com/150');
        $manager->persist($student);
        $manager->flush();
    }

    
}
