<?php

namespace App\Controller;




use App\Entity\Commande;
use App\Entity\Paiement;
use App\Entity\Repas;
use App\Repository\RepasRepository;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PaiementController extends AbstractController
{
    /**
     * @Route("", name="paiement")
     */
    public function index(Request $request, EntityManagerInterface $em, SessionInterface $session, RepasRepository $repasRepository)
    {
        \Stripe\Stripe::setApiKey('sk_test_51HEWz5LDGj5KeXGgHutzw0dSS6rfrCstf8wrV0G8Xrxwrtuc7YuNLTXXfT5KDVPHM3Xx3vv0pT04Jtj6eVjEPdj200yU5O6TaT');

// You can find your endpoint's secret in your webhook settings
        $endpoint_secret = 'whsec_aceUbsHXSeRjvshdcqJ6rpbNGZFDwm9u';
        $event = null;
        $header = 'Stripe-Signature';
        $signature = $request->headers->get($header);
        $payload = @file_get_contents('php://input');



        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $signature, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }

// Handle the checkout.session.completed event
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


        if ($event->type == 'payment_intent.succeeded')

        http_response_code(200);

        return new Response();

    }

}

