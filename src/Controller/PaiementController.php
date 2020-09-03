<?php

namespace App\Controller;






use App\Repository\RepasRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PaiementController extends AbstractController
{
    /**
     * @Route("paiement", name="paiement")
     */
    public function index(Request $request, EntityManagerInterface $em, SessionInterface $session, RepasRepository $repasRepository)
    {

        \Stripe\Stripe::setApiKey('sk_test_51HEWz5LDGj5KeXGgHutzw0dSS6rfrCstf8wrV0G8Xrxwrtuc7YuNLTXXfT5KDVPHM3Xx3vv0pT04Jtj6eVjEPdj200yU5O6TaT');

// You can find your endpoint's secret in your webhook settings
        $endpoint_secret = 'whsec_evJkprgfTdUF66196QIJOYATNr0mii1E

';
        $payload = @file_get_contents('php://input');
        $event = null;

        try {
            $event = \Stripe\Event::constructFrom(
                json_decode($payload, true)
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        }

// Handle the event
        switch ($event->type) {
            case 'payment_intent.succeeded':

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




                break;
            case 'payment_method.attached':
                $paymentMethod = $event->data->object; // contains a \Stripe\PaymentMethod
                // Then define and call a method to handle the successful attachment of a PaymentMethod.
                // handlePaymentMethodAttached($paymentMethod);
                break;
            // ... handle other event types
            default:
                // Unexpected event type
                http_response_code(400);
                exit();
        }

        http_response_code(200);



        return $this->render('paiement/index.html.twig', [
            'controller' => 'controller',
        ]);

    }



}

