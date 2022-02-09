<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Entity\Direccion;
use App\Form\DireccionType;

class DireccionController extends AbstractController
{
    /**
     * @Route("/app/direccion", name="direccion")
     */
    public function index(): Response
    {
        return $this->render('Direccion/index.html.twig', [
            'controller_name' => 'DireccionController',
        ]);
    }
}
