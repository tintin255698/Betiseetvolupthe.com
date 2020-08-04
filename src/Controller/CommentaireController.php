<?php

namespace App\Controller;

use App\Entity\Commentaire;


use App\Entity\Portefeuille;
use App\Entity\User;
use App\Form\CommentaireType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommentaireController extends AbstractController
{
    /**
     * @Route("/commentaire", name="commentaire")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Commentaire::class)->findByExampleField();
        $repo2 = $this->getDoctrine()->getRepository(Commentaire::class)->findByExampleField3();
        dump($repo2);





        return $this->render('commentaire/index.html.twig', [
            'repo' => $repo,
            'repo2'=>$repo2]);

    }

    /**
     * @Route("/ajout/commentaire", name="add_commentaire")
     */
    public function commentaire(Request $request)
    {

        $post = new Commentaire();

        $post->setUser($this->getUser());

        $form = $this->createForm(CommentaireType::class, $post);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($post);
            $doctrine->flush();

            $this->addFlash(
                'success',
                '<strong>Votre commentaire a bien été enregistré !</strong>'
            );


            return $this->redirectToRoute('commentaire');
        }


        $repo = $this->getDoctrine()->getRepository(Commentaire::class)->findByExampleField4();

        return $this->render('commentaire/commentaire.html.twig', array(
            'form' => $form->createView(),
            'repo' => $repo
        ));
    }










}