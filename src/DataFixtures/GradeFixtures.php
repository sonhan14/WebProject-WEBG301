<?php

namespace App\DataFixtures;

use App\Entity\Grade;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class GradeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $grade = new Grade();
        $grade->setstudentName('Anh Tu');
        $grade->setGrade(5.0);
        $manager->persist($grade);
        $manager->flush();
    }
}
