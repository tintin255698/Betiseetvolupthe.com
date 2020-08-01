<?php

namespace App\Controller;

use App\Entity\Commentaire;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CommentaireController extends AbstractController
{
    /**
     * @Route("/commentaire", name="commentaire")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $pla = $repo->findall();

        return $this->render('commentaire/index.html.twig', [
            'pla'=>$pla]);

}}