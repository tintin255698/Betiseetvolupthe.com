<?php

namespace App\Controller;

use App\Entity\Repas;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WebhookController extends AbstractController
{
    /**
     * @Route("/webhook", name="webhook")
     */
    public function index(Request $request, EntityManagerInterface $em)
    {
        $date = date('Y-m-d', strtotime('+1 day'));

        if ($request->isMethod('POST')) {
            $token = $request->request->get('stripeToken');






            $token = $request->request->get('stripeToken');
            \Stripe\Stripe::setApiKey("sk_test_51HEWz5LDGj5KeXGgHutzw0dSS6rfrCstf8wrV0G8Xrxwrtuc7YuNLTXXfT5KDVPHM3Xx3vv0pT04Jtj6eVjEPdj200yU5O6TaT");

// This is a $20.00 charge in US Dollar.

// This is a $20.00 charge in US Dollar.

            try {
            $charge = \Stripe\Charge::create(
                array(
                    'amount' => 2000,
                    'currency' => 'usd',
                    'source' => $token
                )
            );
            $stripeSession = array($charge);
            $sessId = ($stripeSession[0]['status']);
                $repas = new Repas;
                $repas->setType('test');
                $repas->setPrix(2);
                $repas->setDescription('test');
                $repas->setProduit('test');
                $em->persist($repas);
                $em->flush();
            } catch(\Stripe\Exception\CardException $e) {
                // Since it's a decline, \Stripe\Exception\CardException will be caught
                echo 'Status is:' . $e->getHttpStatus() . '\n';
                echo 'Type is:' . $e->getError()->type . '\n';
                echo 'Code is:' . $e->getError()->code . '\n';
                // param is '' in this case
                echo 'Param is:' . $e->getError()->param . '\n';
                echo 'Message is:' . $e->getError()->message . '\n';
                return $this->redirectToRoute('panier');
            } catch (\Stripe\Exception\RateLimitException $e) {
                return $this->redirectToRoute('panier');
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                return $this->redirectToRoute('panier');
            } catch (\Stripe\Exception\AuthenticationException $e) {
                return $this->redirectToRoute('panier');
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                return $this->redirectToRoute('panier');
            } catch (\Stripe\Exception\ApiErrorException $e) {
                return $this->redirectToRoute('panier');
            } catch (Exception $e) {
                return $this->redirectToRoute('panier');
            }

        }

        return $this->render('webhook/index.html.twig', [
            'date' => $date,
        ]);
    }
}
