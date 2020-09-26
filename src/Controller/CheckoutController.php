<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Repas;
use App\Entity\User;
use App\Repository\ComposantMenuRepository;
use App\Repository\MenuRepository;
use App\Repository\RepasRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
    /**
     * @Route("/checkout", name="checkout")
     */
    public function index(Request $request,  SessionInterface $session, RepasRepository $repasRepository, ComposantMenuRepository $composantMenuRepository, MenuRepository $menuRepository, EntityManagerInterface $em)
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

        $stripe = new \Stripe\StripeClient(
            'sk_test_51HEWz5LDGj5KeXGgHutzw0dSS6rfrCstf8wrV0G8Xrxwrtuc7YuNLTXXfT5KDVPHM3Xx3vv0pT04Jtj6eVjEPdj200yU5O6TaT'
        );
            $session2 = $stripe->checkout->sessions->create([
                'success_url' => 'http://127.0.0.1:8000/termine',
                'cancel_url' => 'https://example.com/cancel',
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'amount' => $totaux * 100,
                        'quantity' => 1,
                        'currency' => 'eur',
                        'name'=> 'Total :'
                    ],
                ],
                'mode' => 'payment',
            ]);

            $stripeSession = array($session2);
        $sessId = ($stripeSession[0]['id']);

        $stripeSession = array($session2);
        $payment2 = ($stripeSession[0]['payment_intent']);

        $session->set('payment', $payment2);

        return $this->render('checkout/index.html.twig', [
            'sessId' => $sessId,
        ]);
    }
}
