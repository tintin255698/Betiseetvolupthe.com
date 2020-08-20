<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GalerieController extends AbstractController
{
    /**
     * @Route("/galerie", name="galerie")
     */
    public function index()
    {
        $pla = $this->getDoctrine()->getRepository(Image::class)->findByExampleField();

        return $this->render('galerie/index.html.twig', [
            'pla' => $pla,
        ]);
    }
}
