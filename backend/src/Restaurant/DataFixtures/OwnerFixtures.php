<?php

namespace App\Restaurant\DataFixtures;

use App\Restaurant\Domain\Model\Owner;
use App\Restaurant\Domain\Model\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OwnerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = (new User())
            ->setEmail('owner@foody.com')
            ->setPassword('$2y$13$0z0UbBPqZklaV7NGvdAN3e26OYM9DyUbNr7TTo/WF5apXMHnRU8H2')
            ->setRoles(['ROLE_OWNER']);

        $owner = (new Owner())
            ->setFirstname('Jean')
            ->setLastname('Propriétaire')
            ->setPhoneNumber('+33612345678')
            ->setUser($user);

        $manager->persist($owner);
        $manager->flush();
    }
}
