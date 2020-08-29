<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Repas;
use App\Entity\User;
use App\Repository\RepasRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
    /**
     * @Route("/checkout", name="checkout")
     */
    public function index(Request $request,  SessionInterface $session, RepasRepository $repasRepository, EntityManagerInterface $em)
    {


        $panier = $session->get('panier', []);

        $panierWithData = [];

        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'product' => $repasRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;
        foreach ($panierWithData as $item) {
            $totalItem = $item['product']->getPrix() * $item['quantity'];
            $total += $totalItem;
        }

        $stripe = new \Stripe\StripeClient(
            'sk_test_51HEWz5LDGj5KeXGgHutzw0dSS6rfrCstf8wrV0G8Xrxwrtuc7YuNLTXXfT5KDVPHM3Xx3vv0pT04Jtj6eVjEPdj200yU5O6TaT'
        );

        try {
            $session = $stripe->checkout->sessions->create([
                'success_url' => 'http://127.0.0.1:8000/termine',
                'cancel_url' => 'https://example.com/cancel',
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'amount' => $total * 100,
                        'quantity' => 1,
                        'currency' => 'eur',
                        'name'=> 'Total :'
                    ],
                ],
                'mode' => 'payment',
            ]);
            foreach ($panierWithData as $item) {
                $commande = new Commande();
                $commande->setProduit($item['product']->getProduit());
                $commande->setQuantite($item['quantity']);
                $commande->setTotal($total);
                $commande->setUser($this->getUser());
                $em->persist($commande);
            }
            $em->flush();
        } catch(\Stripe\Exception\CardException $e) {

        } catch (\Stripe\Exception\RateLimitException $e) {
            // Too many requests made to the API too quickly
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API
        } catch (\Stripe\Exception\AuthenticationException $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Network communication with Stripe failed
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
        }

            $stripeSession = array($session);
        $sessId = ($stripeSession[0]['id']);

        return $this->render('checkout/index.html.twig', [
            'sessId' => $sessId,
        ]);
    }
}
