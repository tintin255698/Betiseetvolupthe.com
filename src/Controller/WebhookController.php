<?php

namespace App\Controller;

use App\Entity\Repas;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WebhookController extends AbstractController
{
    /**
     * @Route("/webhook", name="webhook")
     */
    public function index(Request $request, EntityManagerInterface $em)
    {
        $date = date('Y-m-d', strtotime('+1 day'));


           $user = $this->getUser()->getEmail();

        $stripe = new \Stripe\StripeClient(
            'sk_test_51HEWz5LDGj5KeXGgHutzw0dSS6rfrCstf8wrV0G8Xrxwrtuc7YuNLTXXfT5KDVPHM3Xx3vv0pT04Jtj6eVjEPdj200yU5O6TaT'
        );
        $customer = $stripe->customers->create([
            'email' => $user
        ]);

        $stripeSession = array($customer);
        $facture = ($stripeSession[0]['id']);


            $nom = $request->request->get('nom');
            $prenom = $request->request->get('prenom');
            $societe = $request->request->get('societe');
            $telephone = $request->request->get('telephone');
            $adresse = $request->request->get('adresse');
            $code = $request->request->get('code');
            $livraison = $request->request->get('livraison');
            $stripe = $request->request->get('stripe');

            dump($stripe);
            dump($livraison);


        \Stripe\Stripe::setApiKey("sk_test_51HEWz5LDGj5KeXGgHutzw0dSS6rfrCstf8wrV0G8Xrxwrtuc7YuNLTXXfT5KDVPHM3Xx3vv0pT04Jtj6eVjEPdj200yU5O6TaT");

        $intent = \Stripe\PaymentIntent::create([
            'amount' => 1099,
            'currency' => 'eur',
            'payment_method_types' => ['card'],
            'receipt_email'=> $user
        ]);

        $stripeSession = array($intent);
        $success = ($stripeSession[0]['id']);


     dump($intent);







        return $this->render('webhook/index.html.twig', [
            'date' => $date,
            'intent'=> $intent,


        ]);
    }
}
