<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\RepasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class WeebhookController extends AbstractController
{



    /**
     * @Route("/webhook", name="order_checkout")
     */

public function checkoutAction(Request $request, SessionInterface $session, RepasRepository $repasRepository)
{

    $panier = $session->get('panier', []);


    $panierWithData = [];

    foreach ($panier as $id => $quantity) {
        $panierWithData[] = [
            'product' => $repasRepository->find($id),
            'quantity' => $quantity
        ];
    }

    if ($request->isMethod('POST')) {
        $token = $request->request->get('stripeToken');

        \Stripe\Stripe::setApiKey("sk_test_51HEWz5LDGj5KeXGgHutzw0dSS6rfrCstf8wrV0G8Xrxwrtuc7YuNLTXXfT5KDVPHM3Xx3vv0pT04Jtj6eVjEPdj200yU5O6TaT");

        $user = $this->getUser();
        if (!$user->getStripeCustomerId()) {
            $customer = \Stripe\Customer::create([
                'email' => $user->getEmail(),
                'source' => $token
            ]);

            $user->setStripeCustomerId($customer->id);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        } else {
            $customer = \Stripe\Customer::retrieve($user->getStripeCustomerId());
            $customer->source = $token;
            $customer->save();
        }
        foreach ($panierWithData as $item) {
        \Stripe\InvoiceItem::create(array(
            "amount" => $item['product']->getPrix() * 100,
            "currency" => "usd",
            "customer" => $user->getStripeCustomerId(),
            "description" => "First test charge!"
        ));
        }
        $invoice = \Stripe\Invoice::create(array(
            "customer" => $user->getStripeCustomerId()
        ));
        // guarantee it charges *right* now
        $invoice->pay();

        \Stripe\Charge::create(array(
            "amount" => $item['product']->getPrix() * 100,
            "currency" => "usd",
            "source" => $token,
            "description" => "First test charge!",
             "customer" => $user->getStripeCustomerId()
        ));

        \Stripe\PaymentIntent::create([
            'amount' => 1099,
            'currency' => 'eur',
            'payment_method_types' => ['card'],
        ]);



        try {
            $this->chargeCustomer($token);
        } catch (\Stripe\Error\Card $e) {
            $error = 'There was a problem charging your card: '.$e->getMessage();
        }
        if (!$error) {
            $this->addFlash('success', 'Order Complete! Yay!');
            return $this->redirectToRoute('index');
        }

        $this->addFlash('success', 'Order Complete! Yay!');

        return $this->redirectToRoute('index');
    }
    return $this->render('weebhook/hghjhj.html.twig', [
    ]);

}


}
