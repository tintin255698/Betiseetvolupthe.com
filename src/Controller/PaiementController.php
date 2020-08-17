<?php

namespace App\Controller;


use App\Entity\Commande;

use App\Entity\Repas;
use App\Form\PaiementType;
use App\Repository\RepasRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PaiementController extends AbstractController
{
    /**
     * @Route("paiement", name="paiement")
     */
    public function index(Request $request, EntityManagerInterface $em)
    {
        \Stripe\Stripe::setApiKey('sk_test_51HEWz5LDGj5KeXGgHutzw0dSS6rfrCstf8wrV0G8Xrxwrtuc7YuNLTXXfT5KDVPHM3Xx3vv0pT04Jtj6eVjEPdj200yU5O6TaT');

// You can find your endpoint's secret in your webhook settings
        $endpoint_secret = 'whsec_bzjPsdGOSFna6XEAfgjLcOrKdlhbdVNf';
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
        if ($event->type == 'checkout.session.completed') {
            $commande = new repas();
            $commande->setProduit('test2');
            $commande->setDescription('test2');
            $commande->setPrix(42.5);
            $commande->setType('test2');

        }

        http_response_code(200);

        return new Response();

    }

}

