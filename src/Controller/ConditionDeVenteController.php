<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ConditionDeVenteController extends AbstractController
{
    /**
     * @Route("/condition/de/vente/utilisation", name="condition_de_vente")
     */
    public function index()
    {
        return $this->render('condition_de_vente/index.html.twig', [
            'controller_name' => 'ConditionDeVenteController',
        ]);
    }
}
