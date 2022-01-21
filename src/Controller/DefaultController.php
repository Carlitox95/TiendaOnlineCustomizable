<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Producto;
use App\Entity\Configuracion;


class DefaultController  extends AbstractController {

    //Funcion del Index del Sitio
    public function index(): Response {   
     //Obtengo el EntityManager
     $em = $this ->getDoctrine()->getManager();     
     //Obtengo todos los Productos   
     $productos=$em->getRepository(Producto::class)->findByProductosDestacados(); 
     //$productos=$em->getRepository(Producto::class)->findBy(['activo' => '1']);

     //Obtengo los Mensajes de la Home Principal
     $mensajeHome=$em->getRepository(Configuracion::class)->find(1); 
    

        //Retorno a la vista
        return $this->render('index.html.twig', 
            [
             'productos' => $productos,
             'mensajeHome' => $mensajeHome,             
            ]
        );
    }

    public function home(): Response  { 
     //Retorno la vista
     return $this->render('Home/index.html.twig');
    }

}