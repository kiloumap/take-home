<?php

namespace App\Restaurant\DataFixtures;

use App\Restaurant\Domain\Model\Owner;
use App\Restaurant\Domain\Model\Restaurant;
use App\Restaurant\Domain\Model\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RestaurantFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $restaurantsData = [
            [
                'restaurant' => [
                    'name' => 'Le Sakura',
                    'addressLine1' => '14 rue du sushi',
                    'postalCode' => '13100',
                    'city' => 'Aix-en-Provence',
                    'country' => 'France',
                    'phone' => '0442528292',
                    'email' => 'sakurarestoaix@gmail.com',
                    'pickup' => true,
                    'delivery' => true,
                ],
                'owner' => [
                    'firstname' => 'Kei',
                    'lastname' => 'Kobayashi',
                    'phoneNumber' => '+33612345678',
                    'email' => 'kei@kobayashi.com',
                    'password' => '$2y$13$0z0UbBPqZklaV7NGvdAN3e26OYM9DyUbNr7TTo/WF5apXMHnRU8H2',
                ],
            ],
            [
                'restaurant' => [
                    'name' => 'Buon Appetito',
                    'addressLine1' => '135 avenue pasta',
                    'postalCode' => '13090',
                    'city' => 'Aix-en-Provence',
                    'country' => 'France',
                    'phone' => '0442587469',
                    'email' => 'contact@buonappetito.com',
                    'pickup' => false,
                    'delivery' => true,
                ],
                'owner' => [
                    'firstname' => 'Massimo',
                    'lastname' => 'Bottura',
                    'phoneNumber' => '+33698765432',
                    'email' => 'massimo@bottura.com',
                    'password' => '$2y$13$0z0UbBPqZklaV7NGvdAN3e26OYM9DyUbNr7TTo/WF5apXMHnRU8H2',
                ],
            ],
            [
                'restaurant' => [
                    'name' => "Opera de l'océan",
                    'addressLine1' => '45 rue du surf',
                    'postalCode' => '13100',
                    'city' => 'Aix-en-Provence',
                    'country' => 'France',
                    'phone' => '0442587621',
                    'email' => 'restaurant-opera@outlook.fr',
                    'pickup' => true,
                    'delivery' => true,
                ],
                'owner' => [
                    'firstname' => 'Alexandre',
                    'lastname' => 'Fisherman',
                    'phoneNumber' => '+33654321098',
                    'email' => 'alexandre@fisherman.com',
                    'password' => '$2y$13$0z0UbBPqZklaV7NGvdAN3e26OYM9DyUbNr7TTo/WF5apXMHnRU8H2',
                ],
            ],
            [
                'restaurant' => [
                    'name' => 'Level Up',
                    'addressLine1' => '9 avenue de Macintosh',
                    'postalCode' => '13008',
                    'city' => 'Marseille',
                    'country' => 'France',
                    'phone' => '0491568400',
                    'email' => 'reservations@levelup.com',
                    'pickup' => true,
                    'delivery' => false,
                ],
                'owner' => [
                    'firstname' => 'Steve',
                    'lastname' => 'Jobs',
                    'phoneNumber' => '+33611223344',
                    'email' => 'steve@jobs.com',
                    'password' => '$2y$13$0z0UbBPqZklaV7NGvdAN3e26OYM9DyUbNr7TTo/WF5apXMHnRU8H2',
                ],
            ],
            [
                'restaurant' => [
                    'name' => 'Brocofolies',
                    'addressLine1' => '12 boulevard végétal',
                    'postalCode' => '13012',
                    'city' => 'Marseille',
                    'country' => 'France',
                    'phone' => '0491852244',
                    'email' => 'contact-brocofolies@gmail.com',
                    'pickup' => true,
                    'delivery' => true,
                ],
                'owner' => [
                    'firstname' => 'David',
                    'lastname' => 'Propriétaire',
                    'phoneNumber' => '+33666778899',
                    'email' => 'david@legumes.com',
                    'password' => '$2y$13$0z0UbBPqZklaV7NGvdAN3e26OYM9DyUbNr7TTo/WF5apXMHnRU8H2',
                ],
            ],
        ];

        foreach ($restaurantsData as $data) {
            $user = (new User())
                ->setEmail($data['owner']['email'])
                ->setPassword($data['owner']['password'])
                ->setRoles(['ROLE_OWNER']);
            $owner = (new Owner())
                ->setFirstname($data['owner']['firstname'])
                ->setLastname($data['owner']['lastname'])
                ->setPhoneNumber($data['owner']['phoneNumber'])
                ->setUser($user);
            $restaurant = (new Restaurant())
                ->setName($data['restaurant']['name'])
                ->setAddressLine1($data['restaurant']['addressLine1'])
                ->setPostalCode($data['restaurant']['postalCode'])
                ->setCity($data['restaurant']['city'])
                ->setCountry($data['restaurant']['country'])
                ->setPhone($data['restaurant']['phone'])
                ->setEmail($data['restaurant']['email'])
                ->setPickup($data['restaurant']['pickup'])
                ->setDelivery($data['restaurant']['delivery'])
            	->setOwner($owner);
            $manager->persist($restaurant);
        }

        $manager->flush();
    }
}
