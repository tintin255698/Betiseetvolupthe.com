<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Image;
use App\Entity\Repas;
use App\Entity\Reservation;
use App\Form\ContactType;
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
            ]);
        }
}
