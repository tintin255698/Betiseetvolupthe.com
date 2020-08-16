<?php

namespace App\DataFixtures;

use App\Entity\Adresse;
use App\Entity\Boisson;
use App\Entity\Commentaire;
use App\Entity\Eau;
use App\Entity\Jus;
use App\Entity\Limonade;
use App\Entity\Menu;
use App\Entity\Picnic;
use App\Entity\Repas;
use App\Entity\The;
use App\Entity\User;
use App\Entity\Vin;
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

        //Gestion des thes

        for($i=1; $i<=2; $i++) {
            $repas = $repa[mt_rand(0, count($repa) - 1)];

            $the = new The();
            $the->setPrix($faker->randomNumber(2));
            $the->setProduit($faker->company);
            $the->setRepas($repas);

            $manager->persist($the);

        }

        //Gestion des Menus

        for($i=1; $i<=24; $i++) {
            $repas = $repa[mt_rand(0, count($repa) - 1)];

            $menu = new Menu();
            $menu->setProduit($faker->company);
            $menu->setRepas($repas);

            $manager->persist($menu);

        }

        //Gestion des picnic

        for($i=1; $i<=5; $i++) {
            $repas = $repa[mt_rand(0, count($repa) - 1)];

            $picnic = new Picnic();
            $picnic->setProduit($faker->company);
            $picnic->setRepas($repas);

            $manager->persist($picnic);

        }

        //Gestion des eaux

        for($i=1; $i<=8; $i++) {
            $repas = $repa[mt_rand(0, count($repa) - 1)];

            $eau = new Eau();
            $eau->setProduit($faker->company);
            $eau->setPrix($faker->randomNumber(2));
            $eau->setRepas($repas);

            $manager->persist($eau);
        }

        //Gestion des jus

        for($i=1; $i<=9; $i++) {
            $repas = $repa[mt_rand(0, count($repa) - 1)];

            $jus = new Jus();
            $jus->setProduit($faker->company);
            $jus->setPrix($faker->randomNumber(2));
            $jus->setRepas($repas);

            $manager->persist($jus);
        }

        //Gestion des limonades

        for($i=1; $i<=16; $i++) {
            $repas = $repa[mt_rand(0, count($repa) - 1)];

            $limonade = new Limonade();
            $limonade->setProduit($faker->company);
            $limonade->setPrix($faker->randomNumber(2));
            $limonade->setRepas($repas);

            $manager->persist($limonade);
        }

        //Gestion des vins

        for($i=1; $i<=9; $i++) {
            $repas = $repa[mt_rand(0, count($repa) - 1)];

            $vin = new Vin();
            $vin->setProduit($faker->company);
            $vin->setDescription($faker->sentence);
            $vin->setPrix($faker->randomNumber(2));
            $vin->setRepas($repas);

            $manager->persist($vin);
        }

            $manager->flush();
    }

}
