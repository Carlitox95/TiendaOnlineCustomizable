<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Parametro;
use App\Form\ParametroType;


class ParametroController extends AbstractController
{    
    /**
    * Require ROLE_ADMIN for only this controller method.
    *
    * @Route("/app/parametros", name="parametro")
    *
    * @IsGranted("ROLE_ADMIN")
    */
    public function index(): Response {
     //Obtengo el EntityManager
     $em = $this ->getDoctrine()->getManager();    
     //Obtengo todos los Productos que esten disponibles 
     $parametros=$em->getRepository(Parametro::class)->findAll();        
        
        //Retorno la vista
        return $this->render('Parametro/index.html.twig', 
            [
             'parametros' => $parametros,  
            ]
        );
    }


    /**
    * Require ROLE_ADMIN for only this controller method.
    *
    * @Route("/app/parametros/{idParametro}/edit", name="parametro_edit", methods={"GET","HEAD","POST"})
    *
    * @IsGranted("ROLE_ADMIN")
    */
    public function editarParametro($idParametro,Request $request,SluggerInterface $slugger): Response {
     //Obtengo el EntityManager
     $em = $this ->getDoctrine()->getManager();    
     //Obtengo todos los Productos que esten disponibles 
     $parametro=$em->getRepository(Parametro::class)->find($idParametro);        
     //Obtengo el formulario correspondiente
     $form= $this->createForm(ParametroType::class,$parametro);
     //Si se envia el formulario , existe un request
     $form->handleRequest($request);


        //Si se disparo el formulario y es valido
        if ($form->isSubmitted() && $form->isValid()) {
         //Obtengo el producto del formulario
         $parametro = $form->getData();     
         //aviso
         $this->addFlash('exito','Se edito el Parametro correctamente');
         //Le doy persistencia 
         $em->persist($parametro);
         //Asiento los cambios en la base de datos
         $em->flush();     
         //Redirecciono al listado 
         return $this->redirectToRoute('parametro');
        }


        //Retorno la vista
        return $this->render('Parametro/edit.html.twig', 
            [
             'parametro' => $parametro,
             'form' => $form->createView(),   
            ]
        );
    }


}
