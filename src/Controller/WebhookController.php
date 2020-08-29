<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Portefeuille;
use App\Entity\Repas;
use App\Form\PortefeuilleType;
use App\Repository\RepasRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class WebhookController extends AbstractController
{
    /**
     * @Route("/webhook", name="webhook")
     */
    public function index(Request $request, EntityManagerInterface $em, SessionInterface $session, RepasRepository $repasRepository)
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

        $date = date('Y-m-d', strtotime('+1 day'));

        \Stripe\Stripe::setApiKey("sk_test_51HEWz5LDGj5KeXGgHutzw0dSS6rfrCstf8wrV0G8Xrxwrtuc7YuNLTXXfT5KDVPHM3Xx3vv0pT04Jtj6eVjEPdj200yU5O6TaT");

        $user = $this->getUser()->getEmail();

        $stripe = new \Stripe\StripeClient(
            'sk_test_51HEWz5LDGj5KeXGgHutzw0dSS6rfrCstf8wrV0G8Xrxwrtuc7YuNLTXXfT5KDVPHM3Xx3vv0pT04Jtj6eVjEPdj200yU5O6TaT'
        );
        $cust = $stripe->customers->create([
            'email' => $user
        ]);

        $customer = array($cust);
        $customerId = ($customer[0]['id']);

        if ($request->getMethod() == 'POST') {

            $prenom = $request->request->get('prenom');
            $nom = $request->request->get('nom');
            $societe = $request->request->get('societe');
            $telephone = $request->request->get('telephone');
            $adresse = $request->request->get('adresse');
            $code = $request->request->get('code');
            $ville = $request->request->get('ville');
            $livraison = $request->request->get('livraison');
            $numero = $request->request->get('numero');

            $this->redirectToRoute('checkout');
        }





        return $this->render('webhook/index.html.twig', [
            'date' => $date,

        ]);
    }
}
