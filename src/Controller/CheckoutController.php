<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Repas;
use App\Entity\User;
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
    public function index(Request $request,  SessionInterface $session, RepasRepository $repasRepository, EntityManagerInterface $em)
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

        $stripe = new \Stripe\StripeClient(
            'sk_test_51HEWz5LDGj5KeXGgHutzw0dSS6rfrCstf8wrV0G8Xrxwrtuc7YuNLTXXfT5KDVPHM3Xx3vv0pT04Jtj6eVjEPdj200yU5O6TaT'
        );

        $session = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'name' => $item['product']->getProduit(),
                'amount' => $total * 100,
                'currency' => 'eur',
                'quantity' => $item['quantity'],
            ]],
            'success_url' => 'http://127.0.0.1:8000/accepte',
            'cancel_url' => 'https://127.0.0.1:8000/cancel',
        ]);

        if ('success_url') {
            $commande = new Commande();
                $commande->setProduit($item['product']->getProduit());
                $commande->setQuantite($item['quantity']);
                $commande->setTotal($item['product']->getPrix());
                $commande->setUser($this->getUser());
                $em->persist($commande);
                $em->flush();
        } else if ('cancel_url') {
            $this->addFlash('error', 'no paiement');
        }



        $stripeSession = array($session);
        $sessId = ($stripeSession[0]['id']);


        $stripe2 = new \Stripe\StripeClient(
            'sk_test_51HEWz5LDGj5KeXGgHutzw0dSS6rfrCstf8wrV0G8Xrxwrtuc7YuNLTXXfT5KDVPHM3Xx3vv0pT04Jtj6eVjEPdj200yU5O6TaT'
        );
        $stripe2->webhookEndpoints->create([
            'url' => 'https://paiement.serverless.social',
            'enabled_events' => [
                'payment_intent.succeeded',
            ],
        ]);


        return $this->render('checkout/index.html.twig', [
            'sessId' => $sessId,
        ]);
    }
}
