<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Entity\Configuracion;
use App\Form\ConfiguracionType;

class ConfiguracionController extends AbstractController
{
    /**
    * Require ROLE_ADMIN for only this controller method.
    *
    * @Route("/app/configuraciones", name="configuracion")
    *
    * @IsGranted("ROLE_ADMIN")
    */
    public function index(): Response
    {
     //Obtengo el EntityManager
     $em = $this ->getDoctrine()->getManager();    
     //Obtengo todas las entidades 
     $configuraciones=$em->getRepository(Configuracion::class)->findAll();
   
        //Retorno la vista
        return $this->render('configuracion/index.html.twig', 
            [
             'configuraciones' => $configuraciones,
            ]
        );
    }

    /**
    * Require ROLE_ADMIN for only this controller method.
    * 
    * @Route("/app/configuraciones/ver/{idConfiguracion}", name="configuracion_ver")
    * 
    * @IsGranted("ROLE_ADMIN")
    */
    public function verConfiguracion($idConfiguracion): Response {
     //Obtengo el EntityManager
     $em = $this ->getDoctrine()->getManager();     
     //Obtengo la entidad
     $configuracion=$em->getRepository(Configuracion::class)->find($idConfiguracion);
    
        //Retorno a la vista
        return $this->render('Configuracion/ver.html.twig', 
            [
             'configuracion' => $configuracion,
            ]
        );
    }

    /**
    * Require ROLE_ADMIN for only this controller method.
    * 
    * @Route("/app/configuraciones/editar/{idConfiguracion}", name="configuracion_editar", methods={"GET","HEAD","POST"})
    * 
    * @IsGranted("ROLE_ADMIN")
    */
    //Funcion para editar los datos 
    public function editarConfiguracion($idConfiguracion,Request $request,SluggerInterface $slugger): Response {
     //Obtengo el EntityManager
     $entityManager=$this->getDoctrine()->getManager();
     //Obtengo la entidad seleccionada
     $configuracion=$entityManager->getRepository(Configuracion::class)->find($idConfiguracion);   
     //Defino el Formulario
     $form = $this->createForm(ConfiguracionType::class,$configuracion);
     //Si se envia el formulario , existe un request
     $form->handleRequest($request);

        //Si se disparo el formulario y es valido
        if ($form->isSubmitted() && $form->isValid()) {
         //Obtengo la entidad  del formulario
         $configuracion = $form->getData();
         //Le doy persistencia 
         $entityManager->persist($configuracion);
         //Asiento los cambios en la base de datos
         $entityManager->flush();
         //Redirecciono al listado 
         return $this->redirectToRoute('configuracion');
        }

        //Redirecciono a la vista      
        return $this->render('Configuracion/editar.html.twig', 
            [
             'form' => $form->createView(),
             'configuracion' => $configuracion,
            ]
        );
    }

}
