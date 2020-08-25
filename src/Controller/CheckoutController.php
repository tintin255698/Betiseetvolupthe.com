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
                'name' => "Nous vous remercions pour votre commande, d'un total de :",
                'amount' => $total * 100,
                'currency' => 'eur',
                'quantity' => '1',
            ]],
            'success_url' => 'http://127.0.0.1:8000/accepte',
            'cancel_url' => 'https://127.0.0.1:8000/index',
        ]);


        $data = 'a,b,c';
        $len = strlen($data);
        $numero_commande = '';
        for($i=0;$i<50;$i++) {
            $numero_commande .= $data[ rand()%$len ];
        }


        if ('success_url') {
            foreach ($panierWithData as $item) {
                $commande = new Commande();
                $commande->setProduit($item['product']->getProduit());
                $commande->setQuantite($item['quantity']);
                $commande->setTotal($total);
                $commande->setUser($this->getUser());
                $em->persist($commande);

            }
            $em->flush();
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
