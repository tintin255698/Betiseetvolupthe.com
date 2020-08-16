<?php

namespace App\Controller;


use App\Entity\Commande;

use App\Form\PaiementType;
use App\Repository\RepasRepository;

use Doctrine\ORM\EntityManagerInterface;
use http\Client\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PaiementController extends AbstractController
{
    /**
     * @Route("/paiement", name="paiement")
     */
    public function index(SessionInterface $session, RepasRepository $repasRepository, EntityManagerInterface $em, Request $request)
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

        $commande = new Commande();
        if ($session->get('panier', [])) {
            foreach ($panierWithData as $item) {
                $commande->setProduit($item['product']->getProduit());
                $commande->setQuantite($item['quantity']);
                $commande->setTotal($item['product']->getPrix());
                $commande->setUser($this->getUser());
            }
        }



        $form = $this->createForm(PaiementType::class, $commande);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($commande);
            $doctrine->flush();
        }


        \Stripe\Stripe::setApiKey('sk_test_51HEWz5LDGj5KeXGgHutzw0dSS6rfrCstf8wrV0G8Xrxwrtuc7YuNLTXXfT5KDVPHM3Xx3vv0pT04Jtj6eVjEPdj200yU5O6TaT');

        $intent = \Stripe\PaymentIntent::create([
            'amount' => intval($total) * 100,
            'currency' => 'eur',
        ]);


        return $this->render('paiement/index.html.twig', [
            'items' => $panierWithData,
            'form' =>$form-> createView(),
            'intent' => $intent
        ]);
    }

}

