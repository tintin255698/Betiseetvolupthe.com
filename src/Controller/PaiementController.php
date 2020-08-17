<?php

namespace App\Controller;




use App\Entity\Repas;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PaiementController extends AbstractController
{
    /**
     * @Route("", name="paiement")
     */
    public function index(Request $request, EntityManagerInterface $em)
    {
        \Stripe\Stripe::setApiKey('sk_test_51HEWz5LDGj5KeXGgHutzw0dSS6rfrCstf8wrV0G8Xrxwrtuc7YuNLTXXfT5KDVPHM3Xx3vv0pT04Jtj6eVjEPdj200yU5O6TaT');

// You can find your endpoint's secret in your webhook settings
        $endpoint_secret = 'whsec_DEnmwaJdtTLWR0Y7Z7vA0WWGW1sTJwht';
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
        if ($event->type == 'payment_intent.succeeded') {
            $commande = new repas();
            $commande->setProduit('test2');
            $commande->setDescription('test2');
            $commande->setPrix(4.2);
            $commande->setType('test2');
            $em->persist($commande);
            $em->flush();
        }

        http_response_code(200);

        return new Response();

    }

}

