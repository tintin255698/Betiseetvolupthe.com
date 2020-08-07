<?php

namespace App\Controller;

use App\Entity\Repas;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Repas::class);
        $pla = $repo->findall();

dd($pla);

        return $this->render('test/index.html.twig', [
            'pla' => $pla,
        ]);
    }
}
