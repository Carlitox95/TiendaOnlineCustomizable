<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImagenController extends AbstractController
{
    /**
     * @Route("/imagen", name="imagen")
     */
    public function index(): Response
    {
        return $this->render('imagen/index.html.twig', [
            'controller_name' => 'ImagenController',
        ]);
    }
}
