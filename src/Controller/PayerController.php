<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PayerController extends AbstractController
{
    /**
     * @Route("/payer", name="payer")
     */
    public function index(Request $request)
    {
        if ($this->getUser()) {
          return $this->redirectToRoute('checkout');
     } else {
          return $this->redirectToRoute('connexion');
        }

    }
}
