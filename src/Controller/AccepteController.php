<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Commande;
use App\Form\AccepteType;
use App\Repository\RepasRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccepteController extends AbstractController
{
    /**
     * @Route("/accepte", name="accepte")
     */
    public function index(Request $request, SessionInterface $session, RepasRepository $repasRepository)
    {
        $post = new Adresse();

        $post->setUser($this->getUser());

        $form = $this->createForm(AccepteType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($post);
            $doctrine->flush();

            return $this->redirectToRoute('checkout');

        }

        return $this->render('accepte/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/termine", name="termine")
     */
    public function termine(SessionInterface $session, RepasRepository $repasRepository, EntityManagerInterface $em)
    {
        $payment = $session->get('payment');

        \Stripe\Stripe::setApiKey(
            'sk_test_51HEWz5LDGj5KeXGgHutzw0dSS6rfrCstf8wrV0G8Xrxwrtuc7YuNLTXXfT5KDVPHM3Xx3vv0pT04Jtj6eVjEPdj200yU5O6TaT'
        );

        $intent = \Stripe\PaymentIntent::retrieve([
            'id' => $payment
        ]);

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

        if ($intent) {
            foreach ($panierWithData as $item) {
                $commande = new Commande();
                $commande->setProduit($item['product']->getProduit());
                $commande->setQuantite($item['quantity']);
                $commande->setTotal($total);
                $commande->setUser($this->getUser());
                $em->persist($commande);
            }
            $em->flush();
            $this->get('session')->remove('panier');
        }
        return $this->render('accepte/termine.html.twig', [
            'form' => 'form'
        ]);
    }

}
