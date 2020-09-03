<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Commande;
use App\Entity\Commentaire;
use App\Entity\Image;
use App\Entity\Reservation;
use App\Entity\User;
use App\Form\AdresseType;
use App\Form\EditUserType;
use App\Form\ImageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    /**
     * @Route("admin", name="admin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function admin()
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $pla = $repo->findall();

        return $this->render('admin/admin.html.twig', [
            'pla' => $pla,
        ]);
    }

    /**
     * @Route("admin/modification/{id}", name="admin_modifier")
     * @IsGranted("ROLE_ADMIN")
     */

    public function modification(Request $request, User $user)
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($user);
            $doctrine->flush();


            $this->addFlash(
                'success',
                "<strong>Vous avez bien modifie le statut de l'utilisateur !</strong>"
            );

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/edit.user.html.twig', [
            'usersform' => $form->createView()
        ]);
    }


    /**
     * @Route("admin/image", name="admin_image")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(Request $request)
    {
        // Formulaire insertion image

        $image = new Image();

        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $doctrine = $this->getDoctrine()->getManager();
                $doctrine->persist($image);
                $doctrine->flush();
        }


        $repo = $this->getDoctrine()->getRepository(Image::class);
        $pla = $repo->findall();

        return $this->render('admin/index.html.twig', [
            'imageForm' =>$form->createView(),
            'pla'=>$pla
        ]);
    }

    /**
     * @Route("/admin/image/supprimer/{id}", name="supprimer_image")
     * @IsGranted("ROLE_ADMIN")
     */
    public function supprimerImage(Image $id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("admin/commentaire/afficher/", name="afficher_commentaire")
     * @IsGranted("ROLE_ADMIN")
     */
    public function afficherCommentaire()
    {
        $repo = $this->getDoctrine()->getRepository(Commentaire::class)->findByExampleField();

        return $this->render('admin/commentaire.html.twig', [
            'repo'=>$repo
        ]);
    }

    /**
     * @Route("admin/commentaire/supprimer/{id}", name="supprimer_commentaire")
     * @IsGranted("ROLE_ADMIN")
     */
    public function supprimerCommentaire(Commentaire $id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        return $this->redirectToRoute('afficher_commentaire');
    }

    /**
     * @Route("admin/reservations", name="reservation")
     * @IsGranted("ROLE_ADMIN")
     */
    public function users()
    {
        $repo = $this->getDoctrine()->getRepository(reservation::class);
        $pla = $repo->findall();

        return $this->render('admin/reservation.html.twig', [
            'pla' => $pla,
        ]);
    }

    /**
     * @Route("admin/reservation/supprimer/{id}", name="supprimer_reservation")
     * @IsGranted("ROLE_ADMIN")
     */
    public function supprimerReservation(Reservation $id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        return $this->redirectToRoute('reservation');
    }

    /**
     * @Route("admin/afficher/commande", name="afficher_commande")
     * @IsGranted("ROLE_ADMIN")
     */
    public function afficherCommande()
    {

        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $pla = $repo->findall();


        return $this->render('admin/commande.html.twig', [
            'pla' => $pla,
        ]);

    }

    /**
     * @Route("admin/supprimer/commande/{id}", name="supprimer_commande")
     * @IsGranted("ROLE_ADMIN")
     */
    public function supprimerCommande(Commande $id)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        return $this->redirectToRoute('afficher_commande');

    }

    /**
     * @Route("admin/afficher/adresse", name="afficher_adresse")
     * @IsGranted("ROLE_ADMIN")
     */
    public function afficherAdresse()
    {

        $repo = $this->getDoctrine()->getRepository(Adresse::class);
        $pla = $repo->findall();


        return $this->render('admin/adresse.html.twig', [
            'pla' => $pla,
        ]);

    }


    /**
     * @Route("admin/supprimer/commande/{id}", name="supprimer_commande")
     * @IsGranted("ROLE_ADMIN")
     */
    public function supprimerAdresse(Adresse $id)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        return $this->redirectToRoute('afficher_adresse');

    }


    /**
     * @Route("admin/dashboard", name="dashboard")
     * @IsGranted("ROLE_ADMIN")
     */
    public function dashboard()
    {
        return $this->render('admin/dashboard.html.twig', [
            'pla' => 'dashboard'
        ]);

    }




}
