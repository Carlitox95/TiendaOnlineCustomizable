<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Entity\User;
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
    

    /**
     * @Route("/app/direccion/editar", name="direccion_modificar")
    */
    public function modificarDireccion(Request $request): Response {
     //Obtengo el EntityManager
     $em = $this ->getDoctrine()->getManager();   
     //Obtengo el usuario logueado
     $usuarioLogueado=$this->get('security.token_storage')->getToken()->getUser();
     //Obtengo mi usuario de la BD
     $usuario=$em->getRepository(User::class)->find($usuarioLogueado->getId());
        
        //Si el usuario no tiene creada ninguna direccion
        if(!$usuarioLogueado->getDireccion()) {
         //$direccion=$this->crearDireccion($usuarioLogueado);       
         $direccion=new Direccion();         
        }
        else {
         $direccion=$usuario->getDireccion();
        }

     //Obtengo el formulario correspondiente
     $form= $this->createForm(DireccionType::class,$direccion);
     //Si se envia el formulario , existe un request
     $form->handleRequest($request);

        //Si se disparo el formulario y es valido
        if ($form->isSubmitted() && $form->isValid()) {
         //Obtengo datos del formulario
         $direccion=$form->getData();
         //Asigno la Direccion al Usuario
         $usuario->setDireccion($direccion);
         //Le doy persistencia
         $em->persist($usuario);
         //Asiento los cambios en la base de datos
         $em->flush();
         //Aviso
         $this->addFlash('exito','Se ha modificado la direccion correctamente');
         //Redirecciono 
         return $this->redirectToRoute('user');
        }
      
        return $this->render('Direccion/formulario.html.twig', 
            [
             'form' => $form->createView(),
             'usuario' => $usuario,
            ]
        );




    }
}
