<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ResetPassType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');

    }

    /**
     * @Route("/oubli-pass", name="app_forgotten_password")
     */
    public function forgottenPass(Request $request, UserRepository $userrepo, \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator)
    {
        $form = $this->createForm(ResetPassType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $donnees = $form->getData();
            $user = $userrepo->findOneByEmail($donnees['email']);
            if (!$user) {
                $this->addFlash('danger', "Cette adresse n'existe pas");
               return $this->redirectToRoute('index');
            }
            $token = $tokenGenerator->generateToken();

            try {
                $user->setResetToken($token);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
            } catch (\Exception $e){
                $this->addFlash('warning', 'Une erreur est survenue :'. $e->getMessage());
                return $this->redirectToRoute('index');
            }

            $url = $this->generateUrl('app_reset_password', ['token'=>$token],
            UrlGeneratorInterface::ABSOLUTE_URL);

            $message = (new \Swift_Message('Nouveau compte'))

                ->setFrom('votre@adresse.fr')

                ->setTo($user->getEmail())

                ->setBody(
                    "<p>Bonjour,</p><p>Une demande de reinitialistion de mot de passe a ete effectuee pour le site
                BetisesetVolupthe.fr. Veuillez copier sur le lien suivant :".$url.'</p>','text/html'
                );

            $mailer->send($message);

            $this->addFlash('message', 'Un email de reinitilisation vient vous de vous etre envoye');

            return $this->redirectToRoute('index');
      }

        return $this->render('security/forgotten_password.html.twig', [
            'emailForm' => $form->createView()
        ]);

    }

    /**
     * @Route("/reset-pass/{token}", name="app_reset_password")
     */
    public function resetPassword($token, Request $request, UserPasswordEncoderInterface $passwordEncoder){
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['reset_token'=>$token]);

        if(!$user){
            $this->addFlash('danger', 'Token inconnu');
            return $this->redirectToRoute('index');
        }

        if($request->isMethod('POST')){
            $user->setResetToken(null);
            $user->setPassword($passwordEncoder->encodePassword($user,$request->request->get('password')));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'Mot de passe modifie avec succes');
            return $this->redirectToRoute('app_login');

        } else {
            return $this->render('security/reset_password.html.twig',
                ['token'=> $token]
            );
        }
    }




}
