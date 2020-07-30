<?php

namespace App\DataFixtures;

use App\Entity\Adresse;
use App\Entity\Commentaire;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');

        $users =[];

            //Gestion des utilisateurs

        for($i=1; $i<=30; $i++) {

            $user = new User();

            $user->setPrenom($faker->firstName);
            $user->setNom($faker->lastName);
            $user->setEmail($faker->email);
            $user->setTelephone($faker->phoneNumber);
            $user->setPassword($faker->password(15));

            $manager->persist($user);
            $users[] = $user;

        }

        //Gestion des commentaires

        for($i=1; $i<=30; $i++) {
            $user = $users[mt_rand(0,count($users) - 1)];

            $commentaire = new Commentaire();
            $commentaire->setNote($faker->randomNumber());
            $commentaire->setContenu(($faker->sentence));
            $commentaire->setUser($user);
            $manager->persist($commentaire);
        }


        // Gestion des adresses

        for($i=1; $i<=30; $i++) {

            $user = $users[mt_rand(0,count($users) - 1)];

            $adresse = new Adresse();

            $adresse->setPrenom($faker->firstName);
            $adresse->setNom($faker->lastName);
            $adresse->setAdresse($faker->streetName);
            $adresse->setAdresse2($faker->streetAddress);
            $adresse->setCp($faker->postcode);
            $adresse->setVille($faker->city);
            $adresse->setUser($user);

            $manager->persist($adresse);
        }

        $manager->flush();
    }
}
