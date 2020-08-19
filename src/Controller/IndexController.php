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
     * @Route("index", name="index")
     */
    public function index(Request $request, \Swift_Mailer $mailer )
    {
        // Formulaire de contact

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            $message = (new \Swift_Message('Nouveau Contact'))
                ->setFrom($contact['Email'])
                ->setTo('votre@adresse.fr')
                ->setBody(
                    $this->renderView(
                        'email/contact.html.twig', compact('contact')
                    ),
                    'text/html'
                );
            $mailer->send($message);
        }


            // Formulaire de reservation

            $reservation = new Reservation();

            $form1 = $this->createForm(ReservationType::class, $reservation);

            $form1->handleRequest($request);

            if ($form1->isSubmitted() && $form1->isValid()) {
                $doctrine = $this->getDoctrine()->getManager();
                $doctrine->persist($reservation);
                $doctrine->flush();
                $this->addFlash('success', 'Nous vous remercions pour votre réservation');
                }

                    $contact = $form1["email"]->getData();

                $message = (new \Swift_Message('Nouvelle Reservation'))
                    ->setFrom('betisesetvolupthe@gmail.com')
                    ->setTo($contact)
                    ->setBody(
                        $this->renderView(
                            'email/reservation.html.twig', compact('reservation')
                        ),
                        'text/html'
                    )
                ;
                $mailer->send($message);


        // Distance


        $maj = new Livraison();

        $form2 = $this->createForm(LivraisonType::class, $maj);
        $form2->handleRequest($request);
        if ($form2->isSubmitted() && $form2->isValid()) {
            $numero = $form2["numero"]->getData();
            $rue = $form2["rue"]->getData();
            $cp = $form2["cp"]->getData();
            $ville = $form2["ville"]->getData();

            dump($numero);
            dump($rue);
            dump($cp);
            dump($ville);

            $opts = array('http' => array('header' => "User-Agent: Betiseetvolupthe"));
            $context = stream_context_create($opts);

            $json = file_get_contents('http://nominatim.openstreetmap.org/search?format=json&limit=1&q=79 rue des granges, 25000 besancon', false, $context);

            $obj = json_decode($json, true);

            $pi80 = M_PI / 180;
            $lat1 = $obj[0]['lat'] * $pi80 ;
            $lng1 = $obj[0]['lon'] * $pi80 ;

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

        // Images
        $repo = $this->getDoctrine()->getRepository(Image::class);
        $pla = $repo->findall();


        // Commentaires

        $repo = $this->getDoctrine()->getRepository(Commentaire::class)->findByExampleField2();

        // Repas

        $repo2 = $this->getDoctrine()->getRepository(Repas::class);
        $jus = $repo2 ->findBy(
            array('type'=> 'jus'),
            array('produit' => 'ASC')
        );

        $limonade = $repo2->findByType(['limonade'=>'limonade']);
        $mortuacienne = $repo2->findByType(['mortuacienne'=>'mortuacienne']);
        $eau = $repo2->findByType(['eau'=>'eau']);
        $vin = $repo2->findByType(['vin'=>'vin']);
        $picnic = $repo2->findByType(['pic-nic'=>'pic-nic']);
        $the = $repo2->findByType(['the'=>'the']);
        $entree = $repo2->findByType(['entre'=>'entre']);
        $plat = $repo2->findByType(['plat'=>'plat']);
        $dessert = $repo2->findByType(['dessert'=>'dessert']);
        $piquenique = $repo2->findByType(['pique-nique'=>'pique-nique']);
        $menu = $repo2->findByType(['menu'=>'menu']);


            return $this->render('index/index.html.twig', [
                'reservationForm' => $form1->createView(),
                'contactForm' =>$form->createView(),
                'pla'=>$pla,
                'repo'=>$repo,
                'jus' => $jus,
                'limonade' => $limonade,
                'mortuacienne' => $mortuacienne,
                'eau' => $eau,
                'vin' => $vin,
                'picnic' => $picnic,
                'the' => $the,
                'entree'=>$entree,
                'plat' => $plat,
                'dessert' => $dessert,
                'piquenique' => $piquenique,
                'menu' => $menu,
                'form' => $form2->createView(),
            ]);
        }
}
