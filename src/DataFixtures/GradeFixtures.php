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
        $grade->setName('Grade 1');
        $grade->setDescription('This is grade 1');
        $manager->persist($grade);
        $manager->flush();
    }
}
