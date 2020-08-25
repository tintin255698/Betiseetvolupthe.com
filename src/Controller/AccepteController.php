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

            return $this->redirectToRoute('termine');

        }

        $panier = $session->get('panier', []);


        $panierWithData = [];

        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'product' => $repasRepository->find($id),
                'quantity' => $quantity
            ];
        }
        return $this->render('accepte/index.html.twig', [
            'form' => $form->createView(),
            'items' => $panierWithData,
        ]);
    }


    /**
     * @Route("/termine", name="termine")
     */
    public function termine()
    {
        $this->get('session')->remove('panier');

        return $this->render('accepte/termine.html.twig', [
            'form' => 'form'
        ]);
    }

}
