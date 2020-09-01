<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Form\AccepteType;
use App\Repository\RepasRepository;
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

        $post = new Adresse();

        $post->setUser($this->getUser());

        $form = $this->createForm(AccepteType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($post);
            $doctrine->flush();

            $this->addFlash(
                'success',
                "<strong>Votre adresse est bien validée, merci pour votre commande</strong>"
            );

            return $this->redirectToRoute('checkout');

        }

        return $this->render('accepte/index.html.twig', [
            'form' => $form->createView(),
            'date' =>$date,
            'total'=>$total
        ]);
    }


    /**
     * @Route("/termine", name="termine")
     */
    public function termine( SessionInterface $session)
    {
        $payment = $session->get('payement');

        \Stripe\Stripe::setApiKey(
            'sk_test_51HEWz5LDGj5KeXGgHutzw0dSS6rfrCstf8wrV0G8Xrxwrtuc7YuNLTXXfT5KDVPHM3Xx3vv0pT04Jtj6eVjEPdj200yU5O6TaT'
        );

        $intent = \Stripe\PaymentIntent::retrieve([
            'id' => $payment
        ]);


        $payload = @file_get_contents('php://input');


        dump($intent);
        dump($payload);


        return $this->render('accepte/termine.html.twig', [
            'form' => 'form'
        ]);
    }

}
