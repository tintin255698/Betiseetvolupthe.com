<?php

namespace App\Controller;

use App\Repository\RepasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
    /**
     * @Route("/checkout", name="checkout")
     */
    public function index(Request $request,  SessionInterface $session, RepasRepository $repasRepository)
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

        \Stripe\Stripe::setApiKey('sk_test_51HEWz5LDGj5KeXGgHutzw0dSS6rfrCstf8wrV0G8Xrxwrtuc7YuNLTXXfT5KDVPHM3Xx3vv0pT04Jtj6eVjEPdj200yU5O6TaT');


        $token = $request->request->get('stripeToken');
        $user = $this->getUser();
        if ($user->getStripeCustomerId()) {
            $customer = \Stripe\Customer::create([
                'email' => $user->getEmail(),
                'source' => $token
            ]);

            $user->setStripeCustomerId($customer->id);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }

        \Stripe\InvoiceItem::create([
            "amount" => $item['product']->getPrix() * 100,
            "currency" => "usd",
            "customer" => $user->getStripeCustomerId(),
            "description" => "First test charge!",
        ]);

        $invoice = \Stripe\Invoice::create([
            "customer" => $user->getStripeCustomerId(),
            'collection_method' => 'charge_automatically',
        ]);
        $invoice->pay();


        $stripe = new \Stripe\StripeClient(
            'sk_test_51HEWz5LDGj5KeXGgHutzw0dSS6rfrCstf8wrV0G8Xrxwrtuc7YuNLTXXfT5KDVPHM3Xx3vv0pT04Jtj6eVjEPdj200yU5O6TaT'
        );

        $session = $stripe->checkout->sessions->create([
            'customer' => $user->getStripeCustomerId(),
            'payment_method_types' => ['card'],
            'line_items' => [[
                'name' => $item['product']->getProduit(),
                'amount' => $item['product']->getPrix() * 100,
                'currency' => 'eur',
                'quantity' => $item['quantity'],
            ]],
            'success_url' => 'https://example.com/success',
            'cancel_url' => 'https://example.com/cancel',
        ]);

        $stripeSession = array($session);
        $sessId = ($stripeSession[0]['id']);



        return $this->render('weebhook/index.html.twig', [
            'sessId' => $sessId,
        ]);
    }
}
