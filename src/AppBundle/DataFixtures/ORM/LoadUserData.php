<?php
// src/AppBundle/DataFixtures/ORM/LoadUserData.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('user');
        $user->setEmail('user@domain.com');
        $user->setPlainPassword('user');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_USER'));

        $naturaliste = new User();
        $naturaliste->setUsername('naturaliste');
        $naturaliste->setEmail('naturaliste@domain.com');
        $naturaliste->setPlainPassword('naturaliste');
        $naturaliste->setEnabled(true);
        $naturaliste->setRoles(array('ROLE_ADMIN'));

        $admin = new User();
        $admin->setUsername('admin');
        $admin->setEmail('admin@domain.com');
        $admin->setPlainPassword('admin');
        $admin->setEnabled(true);
        $admin->setRoles(array('ROLE_SUPER_ADMIN'));

        $manager->persist($user);
        $manager->persist($naturaliste);
        $manager->persist($admin);
        $manager->flush();

    }
}