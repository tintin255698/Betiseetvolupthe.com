<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Image;
use App\Entity\Livraison;
use App\Entity\Repas;
use App\Entity\Reservation;
use App\Form\ContactType;
use App\Form\LivraisonType;
use App\Form\ReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("", name="index")
     */
    public function index(Request $request, \Swift_Mailer $mailer )
    {

        // Images
        $image = $this->getDoctrine()->getRepository(Image::class)->findByExampleField2();



            return $this->render('index/index.html.twig', [
                'pla'=>$image,
            ]);
        }
}
