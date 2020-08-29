<?php

namespace App\Controller;

use App\Repository\RepasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class NavbarController extends AbstractController
{
    /**
     * @Route("/navbar", name="navbar")
     */
    public function index( SessionInterface $session, RepasRepository $repasRepository)
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


        return $this->render('navbar/index2.html.twig', [
            'total' => $total,
        ]);
    }
}
