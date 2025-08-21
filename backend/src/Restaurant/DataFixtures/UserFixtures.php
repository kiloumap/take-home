<?php

namespace App\Restaurant\DataFixtures;

use App\Restaurant\Domain\Model\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = (new User())
            ->setEmail('admin@foody.com')
            // azerty123456 encrpyted with bcrypt
            ->setPassword('$2y$13$0z0UbBPqZklaV7NGvdAN3e26OYM9DyUbNr7TTo/WF5apXMHnRU8H2')
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);
        $manager->flush();
    }
}
