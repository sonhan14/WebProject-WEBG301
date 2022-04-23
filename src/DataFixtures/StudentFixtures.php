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
        $student->setEmail('niansid@gmail.com');
        $student->setPhone('+380991234567');
        $manager->persist($student);

        $manager->flush();
    }
}
