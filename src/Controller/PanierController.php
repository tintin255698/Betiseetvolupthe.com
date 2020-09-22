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
        $menu = $session->get('menu', []);
        $menu2 = $session->get('menu2', []);

        $panierWithData = [];
        $menuWithData = [];
        $menuWithData2 = [];

        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'product' => $repasRepository->find($id),
                'quantity' => $quantity
            ];
        }

        foreach ($menu as $id => $quantity2) {
            $menuWithData[] = [
                'product' => $composantMenuRepository->find($id),
                'quantity' => $quantity2
            ];
        }

        foreach ($menu2 as $id => $quantity3) {
            $menuWithData2[] = [
                'product' => $menuRepository->find($id),
                'quantity' => $quantity3
            ];
        }


        $total = 0;
        foreach ($panierWithData as $item) {
            $totalItem = $item['product']->getPrix() * $item['quantity'];
            $total += $totalItem;
        }


        $tot = 0;
        foreach ($menuWithData2 as $item2) {
            $totalItem2 = $item2['product']->getPrix() * $item2['quantity'];
            $tot += $totalItem2;
        }

        $totaux = $tot + $total;


        return $this->render('panier/index.html.twig', [
            'items' => $panierWithData,
            'items2' => $menuWithData,
            'items3' => $menuWithData2,
            'total' => $total,
            'tot' => $tot,
            'totaux' => $totaux,
            'menu' => $menu
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
        return $this->redirectToRoute('panier');
    }


    /**
     * @Route("/menu/add/{id}", name="menu_add")
     */
    public function menu($id, Request $request){

        $session = $request->getSession();


        $menu2 = $session->get('menu2', []);

        if(!empty($menu2[$id])){
            $menu2[$id]++;
        } else {
            $menu2[$id] = 1;
        }
        $session->set('menu2', $menu2);
        return $this->redirectToRoute('entree');
    }



    /**
     * @Route("/panier/remove/{id}", name="panier_remove")
     */
    public function remove($id, SessionInterface $session)
    {

        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]--;
        } else if (empty($panier[$id])) {
            unset($panier[$id]);
        }
        $session->set('panier', $panier);
        return $this->redirectToRoute('panier');
    }


    /**
     * @Route("/menu/entree", name="entree")
     */
    public function entree()
    {

        $entre = $this->getDoctrine()->getRepository(ComposantMenu::class)->entree();


        return $this->render('panier/menu.html.twig', array(
            'pla' => $entre,
        ));
    }

    /**
     * @Route("/entree/add/{id}", name="entree_add")
     */
    public function entreeAdd($id, Request $request, ComposantMenuRepository $composantMenuRepository)
    {
        $session = $request->getSession();

        $menu = $session->get('menu', []);

        if (!empty($menu[$id])) {
            $menu[$id]++;
        } else {
            $menu[$id] = 1;
        }
        $session->set('menu', $menu);

        return $this->redirectToRoute('plat');
    }

    /**
     * @Route("/menu/plat", name="plat")
     */
    public function plat()
    {
        $plat = $this->getDoctrine()->getRepository(ComposantMenu::class)->plat();

        return $this->render('panier/plat.html.twig', array(
            'pla' => $plat,
        ));
    }

    /**
     * @Route("/plat/add/{id}", name="plat_add")
     */
    public function platAdd($id, Request $request)
    {

        $session = $request->getSession();

        $menu = $session->get('menu', []);


        if (!empty($menu[$id])) {
            $menu[$id]++;
        } else {
            $menu[$id] = 1;
        }
        $session->set('menu', $menu);

        return $this->redirectToRoute('dessert');
    }

    /**
     * @Route("/menu/dessert", name="dessert")
     */
    public function dessert()
    {
        $plat = $this->getDoctrine()->getRepository(ComposantMenu::class)->dessert();

        return $this->render('panier/dessert.html.twig', array(
            'pla' => $plat,
        ));
    }

    /**
     * @Route("/dessert/add/{id}", name="dessert_add")
     */
    public function dessertAdd($id, Request $request)
    {
        $session = $request->getSession();

        $menu = $session->get('menu', []);

        if (!empty($menu[$id])) {
            $menu[$id]++;
        } else {
            $menu[$id] = 1;
        }
        $session->set('menu', $menu);

        return $this->redirectToRoute('modal');
    }
}


