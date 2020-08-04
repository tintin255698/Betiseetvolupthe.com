<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Image;
use App\Entity\Reservation;
use App\Form\ContactType;
use App\Form\ReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {
        // Formulaire de contact

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try{$contact = $form->getData();
                $this->addFlash('success', 'Nous avons reçu votre message. Nous vous répondrons dès que possible.');
            } catch(\Exception $e) {
                // log $e->getMessage()
                $this->addFlash('error', 'Merci de remplir correctement le formulaire.');
            }

            $message = (new \Swift_Message('Nouveau Contact'))
                ->setFrom($contact['Email'])
                ->setTo('betisesetvolupthe@gmail.com')
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
                try{$doctrine = $this->getDoctrine()->getManager();
                $doctrine->persist($reservation);
                $doctrine->flush();
                $this->addFlash('success', 'Nous vous remercions pour votre réservation. Nous nous préparons à vous recevoir le {get.');
                return $this->redirectToRoute('index');
                } catch(\Exception $e) {
                    // log $e->getMessage()
                    $this->addFlash('error', 'Veuillez remplir correctement le formulaire.');
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

        }

        $repo = $this->getDoctrine()->getRepository(Image::class);
        $pla = $repo->findall();

        $repo = $this->getDoctrine()->getRepository(Commentaire::class)->findByExampleField2();


            return $this->render('index/index.html.twig', [
                'reservationForm' => $form1->createView(),
                'contactForm' =>$form->createView(),
                'pla'=>$pla,
                'repo'=>$repo
            ]);
        }


}
