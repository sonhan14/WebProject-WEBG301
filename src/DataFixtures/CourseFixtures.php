<?php

namespace App\DataFixtures;

use App\Entity\Course;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CourseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $course = new Course();
            $course->setName('Course ' . $i);
            $course->setDescription('Description ' . $i);
            $manager->persist($course);
        }
        $manager->flush();
    }
}
