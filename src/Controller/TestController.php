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
        $jus = $repo->findByType(['jus'=>'jus']);
        $limonade = $repo->findByType(['limonade'=>'limonade']);
        $mortuacienne = $repo->findByType(['mortuacienne'=>'mortuacienne']);
        $eau = $repo->findByType(['eau'=>'eau']);
        $autre = $repo->findByType(['autre'=>'autre']);
        $vin = $repo->findByType(['vin'=>'vin']);
        $picnic = $repo->findByType(['pic-nic'=>'pic-nic']);
        $the = $repo->findByType(['the'=>'the']);
        $entree = $repo->findByType(['entree'=>'entree']);
        $plat = $repo->findByType(['plat'=>'plat']);
        $dessert = $repo->findByType(['dessert'=>'dessert']);
        $piquenique = $repo->findByType(['pique-nique'=>'pique-nique']);
        $menu = $repo->findByType(['menu'=>'menu']);

        return $this->render('test/index.html.twig', [
            'jus' => $jus,
            'limonade' => $limonade,
            'mortuacienne' => $mortuacienne,
            'eau' => $eau,
            'autre' => $autre,
            'vin' => $vin,
            'picnic' => $picnic,
            'the' => $the,
            'entree'=>$entree,
            'plat' => $plat,
            'dessert' => $dessert,
            'piquenique' => $piquenique,
            'menu' => $menu,
        ]);
    }
}
