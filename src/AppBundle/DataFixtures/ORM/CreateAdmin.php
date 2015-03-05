<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use AppBundle\Entity\User;
use AppBundle\Entity\Role;

class CreateAdmin implements FixtureInterface
{
    public function load(ObjectManager $em)
    {
        $admin = new User();
        $admin->setName("admin");
        $admin->setPassword("admin");
        $admin->setEmail("admin@example.com");

        $role = new Role(); 
        $role->setName('SONATA_ADMIN');
        $role->setRole('ROLE_SONATA_ADMIN');

        $admin->addRole($role);
        
        $em->persist($role);
        $em->persist($admin);
        $em->flush();
    }
}
