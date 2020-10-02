<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Commande;
use App\Entity\CommandeComposant;
use App\Entity\CommandeMenu;
use App\Entity\ComposantMenu;
use App\Entity\Menu;
use App\Entity\MotDePasse;
use App\Entity\Portefeuille;
use App\Entity\Repas;
use App\Entity\User;
use App\Form\EditUserType;
use App\Form\GestionPersonnelleType;
use App\Form\MdpType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EspacePersonnelController extends AbstractController
{
    /**
     * @Route("/gestion/personnelle", name="gestion_personnelle_modification")
     */

    public function modification(Request $request)
    {

        $user = $this->getUser();

        $form = $this->createForm(GestionPersonnelleType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($user);
            $doctrine->flush();

            $this->addFlash(
                'success',
                'Votre modification est faite !'
            );


            return $this->redirectToRoute('index');


        }

        return $this->render('espace_personnel/modification.html.twig', [
            'user' => $form->createView()
        ]);
    }

    /**
     * @Route("/gestion/motdepasse", name="gestion_mdp_modification")
     */

    public function motDePasse(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $maj = new MotDePasse();

        $user = $this->getUser();

        $form = $this->createForm(MdpType::class, $maj);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if(password_verify($maj->getAncienMdp(), $user->getPassword())){
                $nouveau = $maj->getNouveauMdp();
                $password = $encoder->encodePassword($user, $nouveau);

                $user->setPassword($password);

                $doctrine = $this->getDoctrine()->getManager();
                $doctrine->persist($user);
                $doctrine->flush();

                $this->addFlash(
                    'success',
                    'Votre mot de passe a bien ete modifié !');

                return $this->redirectToRoute('index');

            } else {
                $form->get('ancienMDP')->addError(new FormError("Le mot de passe saisi n'est pas le bon"));
            }

        }

        return $this->render('espace_personnel/mdp.html.twig', [
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/espace/affichage", name="gestion_affichage")
     */

    public function affichage()
    {

        $user = $this->getUser();
        $repo = $this->getDoctrine()->getRepository(User::class);
        $pla = $repo->find(array('id'=>$user));

        dump($pla);

        return $this->render('espace_personnel/affichage.html.twig', [
            'user' => $pla,
        ]);
    }

    /**
     * @Route("/gestion/supprimer/{id}", name="gestion_suppression")
     */

    public function suppression(User $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($id);
        $entityManager->flush();

        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/gestion/personnelle/commande", name="commande_affichage")
     */
    public function Commande()
    {
        return $this->render('espace_personnel/commande.html.twig', array(
            'repo' => 'repo',
        ));}


    /**
     * @Route("/gestion/personnelle/menu", name="menu_affichage")
     */
    public function affichageMenu()
    {

        $user = $this->getUser()->getId();
        $repo = $this->getDoctrine()->getRepository(CommandeMenu::class)->findByExampleField($user);

        return $this->render('espace_personnel/menu.html.twig', array(
            'repo' => $repo,
        ));}

    /**
     * @Route("/gestion/personnelle/composant", name="composant_affichage")
     */
    public function affichageComposant()
    {

        $user = $this->getUser()->getId();
        $repo = $this->getDoctrine()->getRepository(CommandeComposant::class)->findByExampleField($user);

        return $this->render('espace_personnel/composant.html.twig', array(
            'repo' => $repo,
        ));}

    /**
     * @Route("/gestion/personnelle/boisson", name="boisson_affichage")
     */
    public function affichageBoisson()
    {

        $user = $this->getUser()->getId();
        $repo = $this->getDoctrine()->getRepository(Commande::class)->findByExampleField($user);

        return $this->render('espace_personnel/repas.html.twig', array(
            'repo' => $repo,
        ));}

    /**
     * @Route("/gestion/personnelle/adresse", name="adresse_affichage")
     */
    public function affichageAdresse()
    {

        $user = $this->getUser()->getId();
        $repo = $this->getDoctrine()->getRepository(Adresse::class)->findByExampleField2($user);

        return $this->render('espace_personnel/adresse.html.twig', array(
            'repo' => $repo,
        ));}






}



