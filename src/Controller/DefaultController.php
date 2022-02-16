<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Producto;
use App\Entity\Configuracion;
use App\Entity\Categoria;


class DefaultController  extends AbstractController {

    //Funcion del Index del Sitio
    public function index(): Response {   
     //Obtengo el EntityManager
     $em = $this ->getDoctrine()->getManager();     
     //Obtengo todos los Productos   
     $productos=$em->getRepository(Producto::class)->findByProductosDestacados(); 
     //$productos=$em->getRepository(Producto::class)->findBy(['activo' => '1']);
     //Obtengo todas las categorias existentes
     $categorias=$em->getRepository(Categoria::class)->findBy([],['nombre'=> 'ASC']);
     //Obtengo los Mensajes de la Home Principal
     $mensajeHome=$em->getRepository(Configuracion::class)->find(1); 
    

        //Retorno a la vista
        return $this->render('index.html.twig', 
            [
             'productos' => $productos,
             'categorias' => $categorias,
             'mensajeHome' => $mensajeHome,             
            ]
        );
    }

    public function home(): Response  { 
     //Obtengo el EntityManager
     $em = $this ->getDoctrine()->getManager();     
     //Obtengo todos los Productos   
     $productos=$em->getRepository(Producto::class)->findByProductosDestacados(); 
     //Obtengo todas las categorias existentes
     $categorias=$em->getRepository(Categoria::class)->findBy([],['nombre'=> 'ASC']);
     //Obtengo los Mensajes de la Home Principal
     $mensajeHome=$em->getRepository(Configuracion::class)->find(1); 

     
        //Retorno a la vista
        return $this->render('index.html.twig', 
            [
             'productos' => $productos,
             'categorias' => $categorias,
             'mensajeHome' => $mensajeHome,             
            ]
        );
    }

}