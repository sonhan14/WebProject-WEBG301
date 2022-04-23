<?php

namespace App\DataFixtures;

use App\Entity\Major;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class MajorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 4; $i++) {
            $major = new Major();
            $major->setName('Major ' . $i);
            $major->setDescription('Description ' . $i);
            $major->setImage('https://www.mymusicstaff.com/wp-content/uploads/2015/05/student-management-11.png');
            $manager->persist($major);
        }

        $manager->flush();
    }
}
