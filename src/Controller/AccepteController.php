<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Form\AccepteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AccepteController extends AbstractController
{
    /**
     * @Route("/accepte", name="accepte")
     */
    public function index(Request $request)
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

        return $this->render('accepte/index.html.twig', [
            'form' => $form->createView()
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
