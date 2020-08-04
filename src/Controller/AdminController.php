<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(Request $request)
    {
        // Formulaire insertion image

        $image = new Image();

        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $doctrine = $this->getDoctrine()->getManager();
                $doctrine->persist($image);
                $doctrine->flush();
        }


        $repo = $this->getDoctrine()->getRepository(Image::class);
        $pla = $repo->findall();

        return $this->render('admin/index.html.twig', [
            'imageForm' =>$form->createView(),
            'pla'=>$pla
        ]);
    }

    /**
     * @Route("/admin/image/supprimer/{id}", name="supprimer_image")
     */
    public function supprimerImage(Image $id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        return $this->redirectToRoute('admin');
    }


}
