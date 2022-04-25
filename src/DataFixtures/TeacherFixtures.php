<?php

namespace App\DataFixtures;

use App\Entity\Teacher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TeacherFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i=0; $i<=10; $i++)
        {
            $teachers = new Teacher();
            $teachers -> setName("teacher $i");
            $teachers -> setBirthDay((\DateTime::createFromFormat('Y-m-d','2022-02-08')));
            $teachers -> setEmail(('abc@gmail.com'));
            $manager->persist($teachers);
        }

        $manager->flush();
    }
}
