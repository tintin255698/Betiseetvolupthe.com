<?php

namespace App\Controller;

use App\Entity\ComposantMenu;
use App\Entity\Livraison;
use App\Entity\Menu;
use App\Entity\Repas;
use App\Entity\User;
use App\Form\LivraisonType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    /**
     * @Route("/menu", name="menu")
     */
    public function index(Request $request)
    {
        $maj = new Livraison();

        $form2 = $this->createForm(LivraisonType::class, $maj);
        $form2->handleRequest($request);
        if ($form2->isSubmitted() && $form2->isValid()) {
            $numero = $form2["numero"]->getData();
            $rue = $form2["rue"]->getData();
            $cp = $form2["cp"]->getData();
            $ville = $form2["ville"]->getData();

            $opts = array('http' => array('header' => "User-Agent: Betiseetvolupthe"));
            $context = stream_context_create($opts);

            $json = file_get_contents('http://nominatim.openstreetmap.org/search?format=json&limit=1&q=79 rue des granges, 25000 besancon', false, $context);

            $obj = json_decode($json, true);

            $pi80 = M_PI / 180;
            $lat1 = 0.82444263611449 ;
            $lng1 = 0.10520404384452 ;

            $json2 = file_get_contents('http://nominatim.openstreetmap.org/search?format=json&limit=1&q=' . $numero . ' ' . $rue . ',' . $cp . ' ' . $ville, false, $context);

            $obj2 = json_decode($json2, true);

            $lat2 = $obj2[0]['lat'] * $pi80 ;
            $lng2 = $obj2[0]['lon'] * $pi80 ;

            $r = 6372.797; // rayon moyen de la Terre en km
            $dlat = $lat2 - $lat1;
            $dlng = $lng2 - $lng1;
            $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin(
                    $dlng / 2) * sin($dlng / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            $km = round(($r * $c), 2);

            if ($km <= 10){
                $this->addFlash('success', 'Vous pouvez commander, vous êtes à '. $km.' km !');}
            else {$this->addFlash('danger', 'Vous ne pouvez pas commander, vous êtes à '. $km.' km !');}

        }

        $repo2 = $this->getDoctrine()->getRepository(Repas::class);
        $jus = $repo2->findBy(
            array('type' => 'jus'),
            array('produit' => 'ASC')
        );

        $entre = $this->getDoctrine()->getRepository(ComposantMenu::class)->entree();
        $repa = $this->getDoctrine()->getRepository(ComposantMenu::class)->plat();
        $dessert = $this->getDoctrine()->getRepository(ComposantMenu::class)->dessert();

        $limonade = $repo2->findByType(['limonade' => 'limonade']);
        $eau = $repo2->findByType(['eau' => 'eau']);
        $vin = $repo2->findByType(['vin' => 'vin']);
        $pic = $repo2->findByType(['pic' => 'pic']);
        $the = $repo2->findByType(['the' => 'the']);
        $pique = $repo2->findByType(['pique' => 'pique']);
        $menu = $repo2->findByType(['menu' => 'menu']);
        $autre = $repo2->findByType(['biere' => 'biere']);

        $repo = $this->getDoctrine()->getRepository(Menu::class);
        $pla = $repo->findall();

        return $this->render('menu/index.html.twig', [
            'jus' => $jus,
            'limonade' => $limonade,
            'biere' => $autre,
            'eau' => $eau,
            'vin' => $vin,
            'pic' => $pic,
            'the' => $the,
            'pique' => $pique,
            'menu' => $menu,
            'pla' => $pla,
            'entre' => $entre,
            'repa' => $repa,
            'dessert' => $dessert,
            'form' => $form2->createView(),
        ]);
    }


}

