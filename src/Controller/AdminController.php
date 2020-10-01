<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Commande;
use App\Entity\CommandeComposant;
use App\Entity\CommandeMenu;
use App\Entity\Commentaire;
use App\Entity\ComposantMenu;
use App\Entity\Image;
use App\Entity\Menu;
use App\Entity\Repas;
use App\Entity\Reservation;
use App\Entity\User;
use App\Form\AdresseType;
use App\Form\ComposantMenuType;
use App\Form\EditUserType;
use App\Form\ImageType;
use App\Form\MenuType;
use App\Form\ModifyComposantType;
use App\Form\ModifyrepasType;
use App\Form\RepasType;
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
        return $this->redirectToRoute('admin_image');
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

    /**
     * @Route("admin/menu", name="admin_menu")
     * @IsGranted("ROLE_ADMIN")
     */
    public function menu()
    {
        $repo = $this->getDoctrine()->getRepository(Menu::class);
        $pla = $repo->findall();

        return $this->render('admin/menu.html.twig', [
            'pla' => $pla
        ]);
    }

    /**
     * @Route("admin/composant", name="admin_composant")
     * @IsGranted("ROLE_ADMIN")
     */
    public function composant()
    {
        $repo = $this->getDoctrine()->getRepository(ComposantMenu::class);
        $pla = $repo->findall();

        return $this->render('admin/composant.html.twig', [
            'pla' => $pla
        ]);
    }

    /**
     * @Route("admin/boisson", name="admin_boisson")
     * @IsGranted("ROLE_ADMIN")
     */
    public function boisson()
    {
        $repo = $this->getDoctrine()->getRepository(Repas::class);
        $pla = $repo->findall();

        return $this->render('admin/boisson.html.twig', [
            'pla' => $pla
        ]);

    }

    /**
     * @Route("admin/add/boisson", name="add_boisson")
     * @IsGranted("ROLE_ADMIN")
     */
    public function addBoisson(Request $request)
    {
        $repas = new Repas();

        $form = $this->createForm(RepasType::class, $repas);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($repas);
            $doctrine->flush();
            $this->addFlash('success', 'Boisson correctement ajoutée');
            return $this->redirectToRoute('admin_boisson');
        }

        return $this->render('admin/addrepas.html.twig', [
            'boisson' =>$form->createView(),
        ]);
    }

    /**
     * @Route("admin/add/composant", name="add_composant")
     * @IsGranted("ROLE_ADMIN")
     */
    public function addComposant(Request $request)
    {
        $composant = new ComposantMenu();

        $form = $this->createForm(ComposantMenuType::class, $composant);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($composant);
            $doctrine->flush();
            $this->addFlash('success', 'Composant correctement ajouté');
            return $this->redirectToRoute('admin_composant');
        }

        return $this->render('admin/addcomposant.html.twig', [
            'composant' =>$form->createView(),
        ]);
    }

    /**
     * @Route("admin/modify/menu/{id}", name="modify_menu")
     * @IsGranted("ROLE_ADMIN")
     */
    public function modifyMenu(Menu $id, Request $request)
    {
        $form = $this->createForm(MenuType::class, $id);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($id);
            $doctrine->flush();
            $this->addFlash('success', 'Menu correctement modifié');
            return $this->redirectToRoute('admin_menu');
        }

        return $this->render('admin/addmenu.html.twig', [
            'menu' =>$form->createView(),
        ]);
    }

    /**
     * @Route("admin/modify/composant/{id}", name="modify_composant")
     * @IsGranted("ROLE_ADMIN")
     */
    public function modifyComposant(ComposantMenu $id, Request $request)
    {
        $form = $this->createForm(ModifyComposantType::class, $id);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($id);
            $doctrine->flush();
            $this->addFlash('success', 'Composant correctement modifié');
            return $this->redirectToRoute('admin_composant');
        }
        return $this->render('admin/modifyComposant.html.twig', [
            'composant' =>$form->createView(),
        ]);
    }

    /**
     * @Route("admin/modify/boisson/{id}", name="modify_boisson")
     * @IsGranted("ROLE_ADMIN")
     */
    public function modifyBoisson(Repas $id, Request $request)
    {
        $form = $this->createForm(ModifyrepasType::class, $id);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($id);
            $doctrine->flush();
            $this->addFlash('success', 'Boisson correctement modifiée');
            return $this->redirectToRoute('admin_boisson');
        }

        return $this->render('admin/modifyBoisson.html.twig', [
            'boisson' =>$form->createView(),
        ]);
    }


    /**
     * @Route("admin/delete/boisson/{id}", name="delete_boisson")
     * @IsGranted("ROLE_ADMIN")
     */
    public function deleteBoisson(Repas $id)

    {
        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->remove($id);
        $doctrine->flush();
    return $this->redirectToRoute('admin_boisson');
    }

    /**
     * @Route("admin/delete/composant/{id}", name="delete_composant")
     * @IsGranted("ROLE_ADMIN")
     */
    public function deleteComposant(ComposantMenu $id)

    {
        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->remove($id);
        $doctrine->flush();
        return $this->redirectToRoute('admin_composant');
    }

    /**
     * @Route("admin/commande", name="commande_boisson")
     * @IsGranted("ROLE_ADMIN")
     */
    public function adminCommmandeBoisson()

    {
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $pla = $repo->findall();

        dump($pla);

        return $this->render('admin/commandeBoisson.html.twig', [
            'pla' => $pla,
        ]);
    }

    /**
     * @Route("admin/commandeComposant", name="commande_composant")
     * @IsGranted("ROLE_ADMIN")
     */
    public function adminCommandeComposant()
    {
        $repo = $this->getDoctrine()->getRepository(CommandeComposant::class);
        $pla = $repo->findall();

        dump($pla);

        return $this->render('admin/commandeComposant.html.twig', [
            'pla' => $pla,
        ]);
    }

    /**
     * @Route("admin/commandeMenu", name="commande_menu")
     * @IsGranted("ROLE_ADMIN")
     */
    public function adminCommandeMenu()
    {
        $repo = $this->getDoctrine()->getRepository(CommandeMenu::class);
        $pla = $repo->findall();

        dump($pla);

        return $this->render('admin/commandeMenu.html.twig', [
            'pla' => $pla,
        ]);
    }

    /**
     * @Route("admin/voir", name="commande_voir")
     * @IsGranted("ROLE_ADMIN")
     */
    public function adminCommande()
    {

        return $this->render('admin/commande.html.twig', [
            'pla' => 'pla',
        ]);
    }






}
