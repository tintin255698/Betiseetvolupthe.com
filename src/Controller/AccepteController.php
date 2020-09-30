<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Commande;
use App\Entity\CommandeComposant;
use App\Entity\CommandeMenu;
use App\Entity\Image;
use App\Entity\User;
use App\Form\AccepteType;
use App\Repository\AdresseRepository;
use App\Repository\ComposantMenuRepository;
use App\Repository\MenuRepository;
use App\Repository\RepasRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccepteController extends AbstractController
{
    /**
     * @Route("/accepte", name="accepte")
     */
    public function index(Request $request, SessionInterface $session, RepasRepository $repasRepository)
    {
        $post = new Adresse();

        $post->setUser($this->getUser());

        $form = $this->createForm(AccepteType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($post);
            $doctrine->flush();

            return $this->redirectToRoute('checkout');

        }

        return $this->render('accepte/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/termine", name="termine")
     */
    public function termine(SessionInterface $session, RepasRepository $repasRepository, \Swift_Mailer $mailer, EntityManagerInterface $em,  ComposantMenuRepository $composantMenuRepository, MenuRepository $menuRepository)
    {
        $payment = $session->get('payment');

        \Stripe\Stripe::setApiKey(
            'sk_test_51HEWz5LDGj5KeXGgHutzw0dSS6rfrCstf8wrV0G8Xrxwrtuc7YuNLTXXfT5KDVPHM3Xx3vv0pT04Jtj6eVjEPdj200yU5O6TaT'
        );

        $intent = \Stripe\PaymentIntent::retrieve([
            'id' => $payment
        ]);

        $panier = $session->get('panier', []);
        $composant = $session->get('composant', []);
        $menu = $session->get('menu', []);

        $panierWithData = [];
        $composantWithData = [];
        $menuWithData = [];

        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'product' => $repasRepository->find($id),
                'quantity' => $quantity
            ];
        }
        foreach ($composant as $id => $quantity) {
            $composantWithData[] = [
                'product' => $composantMenuRepository->find($id),
                'quantity' => $quantity
            ];
        }

        foreach ($menu as $id => $quantity) {
            $menuWithData[] = [
                'product' => $menuRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;
        foreach ($panierWithData as $item) {
            $totalItem = $item['product']->getPrix() * $item['quantity'];
            $total += $totalItem;
        }

        $tot = 0;
        foreach ($menuWithData as $item) {
            $totalItem = $item['product']->getPrix() * $item['quantity'];
            $tot += $totalItem;
        }

        $totaux = $tot + $total;

        if ($intent) {
            foreach ($panierWithData as $item) {
                $commande = new Commande();
                $commande->setProduit($item['product']->getProduit());
                $commande->setQuantite($item['quantity']);
                $commande->setTotal($total);
                $commande->setUser($this->getUser());
                $em->persist($commande);
            }
            foreach ($composantWithData as $item) {
                $composant = new CommandeComposant();
                $composant->setProduit($item['product']->getProduit());
                $composant->setQuantite($item['quantity']);

                $composant->setUser($this->getUser());
                $em->persist($composant);
            }
            foreach ($menuWithData as $item) {
                $menu = new CommandeMenu();
                $menu->setProduit($item['product']->getProduit());
                $menu->setQuantite($item['quantity']);
                $menu->setTotal($tot);
                $menu->setUser($this->getUser());
                $em->persist($menu);
            }
            $em->flush();
            $contact = $this->getUser()->getId();
            $image = $this->getDoctrine()->getRepository(Adresse::class)->findByExampleField($contact);
            $commande = $this->getDoctrine()->getRepository(Commande::class)->findByExampleField($contact);
            dump($image);
            dump($commande);

            $email = $this->getUser()->getEmail();

            $message = (new \Swift_Message('Facture'))
                ->setFrom('betisesetvolupthe@gmail.com')
                ->setTo($email)
                ->setBody(
                    $this->renderView(
                        'email/reservation.html.twig', ['panier' => $panierWithData, 'composant'=>$composantWithData,
                            'menu' =>$menuWithData, 'total' => $total, 'tot'=>$tot, 'totaux'=>$totaux, 'contact' => $image, 'commande' => $commande ]
                    ),
                    'text/html'
                );
            $mailer->send($message);

            $message = (new \Swift_Message('Nouvelle Commande'))
                ->setFrom('betisesetvolupthe@gmail.com')
                ->setTo('betisesetvolupthe@gmail.com')
                ->setBody(
                    $this->renderView(
                        'email/contact.html.twig', ['panier' => $panierWithData, 'composant'=>$composantWithData,
                            'menu' =>$menuWithData, 'total' => $total, 'tot'=>$tot, 'totaux'=>$totaux, 'contact' => $image, 'commande' => $commande ]
                    ),
                    'text/html'
                );
            $mailer->send($message);

            $this->get('session')->remove('panier');
            $this->get('session')->remove('composant');
            $this->get('session')->remove('menu');
        }
        return $this->render('accepte/termine.html.twig', [
            'form' => 'form'
        ]);
    }

}
