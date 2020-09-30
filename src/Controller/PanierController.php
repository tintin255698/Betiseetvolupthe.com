<?php

namespace App\Controller;

use App\Entity\ComposantMenu;
use App\Entity\Repas;
use App\Repository\ComposantMenuRepository;
use App\Repository\MenuRepository;
use App\Repository\RepasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier")
     */
    public function index(SessionInterface $session, RepasRepository $repasRepository, ComposantMenuRepository $composantMenuRepository, MenuRepository $menuRepository)
    {
        $panier = $session->get('panier', []);
        $composant = $session->get('composant', []);
        $menu = $session->get('menu', []);

        $panierWithData = [];
        $composantWithData = [];
        $menuWithData = [];

        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'product' => $repasRepository->find($id),
                'quantity' => $quantity
            ];
        }

        foreach ($composant as $id => $quantity) {
            $composantWithData[] = [
                'product' => $composantMenuRepository->find($id),
                'quantity' => $quantity
            ];
        }

        foreach ($menu as $id => $quantity) {
            $menuWithData[] = [
                'product' => $menuRepository->find($id),
                'quantity' => $quantity
            ];
        }


        $total = 0;
        foreach ($panierWithData as $item) {
            $totalItem = $item['product']->getPrix() * $item['quantity'];
            $total += $totalItem;
        }

        $tot = 0;
        foreach ($menuWithData as $item) {
            $totalItem = $item['product']->getPrix() * $item['quantity'];
            $tot += $totalItem;
        }

        $totaux = $tot + $total;


        return $this->render('panier/index.html.twig', [
            'panier' => $panierWithData,
            'composant' => $composantWithData,
            'menu' => $menuWithData,
            'total' => $total,
            'tot' => $tot,
            'totaux' => $totaux,
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="panier_add")
     */
    public function add($id, Request $request){

        $session = $request->getSession();


        $panier = $session->get('panier', []);

        if(!empty($panier[$id])){
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }
        $session->set('panier', $panier);
        return $this->redirectToRoute('modal');
    }

    /**
     * @Route("/menu/add/{id}", name="menu_add")
     */
    public function menu($id, Request $request){

        $session = $request->getSession();


        $menu = $session->get('menu', []);

        if(!empty($menu[$id])){
            $menu[$id]++;
        } else {
            $menu[$id] = 1;
        }
        $session->set('menu', $menu);
        return $this->redirectToRoute('entree');
    }

    /**
     * @Route("/menu/remove", name="menu_remove")
     */
    public function removeMenu()
    {

        $this->get('session')->remove('menu');
        $this->get('session')->remove('composant');

        return $this->redirectToRoute('panier');
    }

    /**
     * @Route("/panier/remove", name="panier_remove")
     */
    public function removePanier()
    {
        $this->get('session')->remove('panier');
        return $this->redirectToRoute('panier');
    }

    /**
     * @Route("/menu/entree", name="entree")
     */
    public function entree()
    {

        $entre = $this->getDoctrine()->getRepository(ComposantMenu::class)->entree();


        return $this->render('panier/menu.html.twig', array(
            'entre' => $entre,
        ));
    }

    /**
     * @Route("/entree/add/{id}", name="entree_add")
     */
    public function entreeAdd($id, Request $request, ComposantMenuRepository $composantMenuRepository)
    {
        $session = $request->getSession();


        $composant = $session->get('composant', []);

        if(!empty($composant[$id])){
            $composant[$id]++;
        } else {
            $composant[$id] = 1;
        }
        $session->set('composant', $composant);

        return $this->redirectToRoute('plat');
    }

    /**
     * @Route("/menu/plat", name="plat")
     */
    public function plat()
    {
        $plat = $this->getDoctrine()->getRepository(ComposantMenu::class)->plat();

        return $this->render('panier/plat.html.twig', array(
            'plat' => $plat,
        ));
    }

    /**
     * @Route("/plat/add/{id}", name="plat_add")
     */
    public function platAdd($id, Request $request)
    {
        $session = $request->getSession();


        $composant = $session->get('composant', []);

        if(!empty($composant[$id])){
            $composant[$id]++;
        } else {
            $composant[$id] = 1;
        }
        $session->set('composant', $composant);

        return $this->redirectToRoute('dessert');
    }

    /**
     * @Route("/menu/dessert", name="dessert")
     */
    public function dessert()
    {
        $plat = $this->getDoctrine()->getRepository(ComposantMenu::class)->dessert();

        return $this->render('panier/dessert.html.twig', array(
            'dessert' => $plat,
        ));
    }

    /**
     * @Route("/dessert/add/{id}", name="dessert_add")
     */
    public function dessertAdd($id, Request $request)
    {
            $session = $request->getSession();

            $composant = $session->get('composant', []);

            if(!empty($composant[$id])){
                $composant[$id]++;
            } else {
                $composant[$id] = 1;
            }
            $session->set('composant', $composant);

        return $this->redirectToRoute('modal');
    }
}





