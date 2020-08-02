<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Image;
use App\Entity\Reservation;
use App\Entity\User;
use App\Form\ContactType;
use App\Form\ReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
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

                $contact = $form1["email"]->getData();


                $this->addFlash(
                    'success',
                    '<strong>Merci pour votre réservation !</strong>');

                $this->get('session')->getFlashBag()->add('error', 'Does Not Exist');


                $message = (new \Swift_Message('Nouvelle Reservation'))
                    ->setFrom('votre@adresse2.fr')
                    ->setTo($contact)
                    ->setBody(
                        $this->renderView(
                            'email/reservation.html.twig', compact('reservation')
                        ),
                        'text/html'
                    )
                ;
                $mailer->send($message);

        }

        $repo = $this->getDoctrine()->getRepository(Image::class);
        $pla = $repo->findall();

        $repo1 = $this->getDoctrine()->getRepository(Commentaire::class);
        $pla1 = $repo1->findby(array(), array('id'=> 'DESC'), 5);

            return $this->render('index/index.html.twig', [
                'reservationForm' => $form1->createView(),
                'contactForm' =>$form->createView(),
                'pla'=>$pla,
                'pla1'=>$pla1
            ]);
        }


}
