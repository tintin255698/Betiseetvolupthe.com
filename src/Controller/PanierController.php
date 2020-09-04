<?php

namespace App\Controller;

use App\Entity\Repas;
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
    public function index(SessionInterface $session, RepasRepository $repasRepository)
    {
        $panier = $session->get('panier', []);


        $panierWithData = [];

        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'product' => $repasRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;
        foreach ($panierWithData as $item) {
            $totalItem = $item['product']->getPrix() * $item['quantity'];
            $total += $totalItem;
        }

        return $this->render('panier/index.html.twig', [
            'items' => $panierWithData,
            'total' => $total
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="panier_add")
     */
    public function add($id, Request $request)
    {

        $session = $request->getSession();

        $panier = $session->get('panier', []);


        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }
        $session->set('panier', $panier);

        return $this->redirectToRoute('modal');
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
     * @Route("/menu/add/{id}", name="menu_add")
     */
    public function menuAdd($id, Request $request, RepasRepository $repasRepository)
    {

        $session = $request->getSession();

        $panier = $session->get('panier', []);


        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }
        $session->set('panier', $panier);


        $panierWithData = [];

        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'product' => $repasRepository->find($id),
                'quantity' => $quantity
            ];
        }

        return $this->redirectToRoute('entree');
    }

    /**
     * @Route("/menu/entree", name="entree")
     */
    public function entree(Request $request, RepasRepository $repasRepository)
    {

        $entre = $this->getDoctrine()->getRepository(Repas::class)->entree();


        return $this->render('panier/menu.html.twig', array(
            'pla' => $entre,
        ));
    }

    /**
     * @Route("/entree/add/{id}", name="entree_add")
     */
    public function entreeAdd($id, Request $request, RepasRepository $repasRepository)
    {

        $session = $request->getSession();

        $panier = $session->get('panier', []);


        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }
        $session->set('panier', $panier);


        $panierWithData = [];

        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'product' => $repasRepository->find($id),
                'quantity' => $quantity
            ];
        }

        return $this->redirectToRoute('plat');
    }

    /**
     * @Route("/menu/plat", name="plat")
     */
    public function plat(Request $request, RepasRepository $repasRepository)
    {

        $plat = $this->getDoctrine()->getRepository(Repas::class)->plat();

        return $this->render('panier/plat.html.twig', array(
            'pla' => $plat,
        ));
    }

    /**
     * @Route("/plat/add/{id}", name="plat_add")
     */
    public function platAdd($id, Request $request, RepasRepository $repasRepository)
    {

        $session = $request->getSession();

        $panier = $session->get('panier', []);


        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }
        $session->set('panier', $panier);


        $panierWithData = [];

        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'product' => $repasRepository->find($id),
                'quantity' => $quantity
            ];
        }

        return $this->redirectToRoute('dessert');
    }

    /**
     * @Route("/menu/dessert", name="dessert")
     */
    public function dessert(Request $request, RepasRepository $repasRepository)
    {

        $plat = $this->getDoctrine()->getRepository(Repas::class)->dessert();

        return $this->render('panier/dessert.html.twig', array(
            'pla' => $plat,
        ));
    }

    /**
     * @Route("/dessert/add/{id}", name="dessert_add")
     */
    public function dessertAdd($id, Request $request, RepasRepository $repasRepository)
    {

        $session = $request->getSession();

        $panier = $session->get('panier', []);


        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }
        $session->set('panier', $panier);


        $panierWithData = [];

        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'product' => $repasRepository->find($id),
                'quantity' => $quantity
            ];
        }

        return $this->redirectToRoute('modal');
    }
}


