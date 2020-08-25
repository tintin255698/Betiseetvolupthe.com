<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Image;
use App\Form\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GalerieController extends AbstractController
{
    /**
     * @Route("/galerie", name="galerie")
     */
    public function index(Request $request)
    {
        $pla = $this->getDoctrine()->getRepository(Image::class)->findByExampleField();

        // Formulaire insertion image

        $image = new Image();

        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($image);
            $doctrine->flush();
        }

        $repo = $this->getDoctrine()->getRepository(Image::class);
        $pla = $repo->findall();


        return $this->render('galerie/index.html.twig', [
            'pla' => $pla,
            'imageForm' =>$form->createView(),

        ]);
    }
}



