<?php
namespace App\DataFixtures;

use App\Entity\Department;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DepartmentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $direction = new Department();
        $direction->setName('Direction');
        $direction->setMail('direction@example.com');
        $manager->persist($direction);

        $rh = new Department();
        $rh->setName('Ressources Humaines');
        $rh->setMail('rh@example.com');
        $manager->persist($rh);

        $com = new Department();
        $com->setName('Communication');
        $com->setMail('com@example.com');
        $manager->persist($com);

        $dev = new Department();
        $dev->setName('Dev Team');
        $dev->setMail('dev@example.com');
        $manager->persist($dev);

        $manager->flush();
    }
}