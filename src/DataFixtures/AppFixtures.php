<?php

namespace App\DataFixtures;

use App\Entity\Adresse;
use App\Entity\Commentaire;
use App\Entity\Repas;
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
            $commentaire->setNote(mt_rand(1, 5));
            $commentaire->setContenu($faker->paragraph());
            $commentaire->setUser($user);
            $manager->persist($commentaire);
        }

        //Gestion des repas

        for($i=1; $i<=2; $i++) {

            $user = $users[mt_rand(0, count($users) - 1)];

            $repas = new Repas();
            $repas->setProduit($faker->company);
            $repas->setPrix($faker->randomNumber(2));
            $repas->setUser($user);

            $manager->persist($repas);
            $repa[] = $repas;
        }


            $manager->flush();
    }

}
