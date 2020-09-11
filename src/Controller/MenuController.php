<?php

namespace App\Controller;

use App\Entity\Repas;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    /**
     * @Route("/menu", name="menu")
     */
    public function index()
    {
        $repo2 = $this->getDoctrine()->getRepository(Repas::class);
        $jus = $repo2->findBy(
            array('type' => 'jus'),
            array('produit' => 'ASC')
        );

        $limonade = $repo2->findByType(['limonade' => 'limonade']);
        $eau = $repo2->findByType(['eau' => 'eau']);
        $vin = $repo2->findByType(['vin' => 'vin']);
        $pic = $repo2->findByType(['pic' => 'pic']);
        $the = $repo2->findByType(['the' => 'the']);
        $entre = $repo2->findByType(['entre' => 'entre']);
        $plat = $repo2->findByType(['plat' => 'plat']);
        $dessert = $repo2->findByType(['dessert' => 'dessert']);
        $pique = $repo2->findByType(['pique' => 'pique']);
        $menu = $repo2->findByType(['menu' => 'menu']);
        $autre = $repo2->findByType(['biere' => 'biere']);

        return $this->render('menu/index.html.twig', [
            'jus' => $jus,
            'limonade' => $limonade,
            'biere' => $autre,
            'eau' => $eau,
            'vin' => $vin,
            'pic' => $pic,
            'the' => $the,
            'entre' => $entre,
            'plat' => $plat,
            'dessert' => $dessert,
            'pique' => $pique,
            'menu' => $menu,

        ]);
    }


}

