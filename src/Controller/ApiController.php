<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Parametro;
use App\Entity\Configuracion;

class ApiController extends AbstractController
{
   /**
   * @Route("/api/estadoVentas", name="api_ventas_estado")
   */
    public function obtenerEstadoVentas(): Response {
    //Obtengo el Entity Manager
    $em = $this ->getDoctrine()->getManager();  
    //Obtengo el parametro del estado de las ventas 
    $parametro=$em->getRepository(Parametro::class)->find(1); 
    //Defino un flag para las ventas
    $flagVentas=false;
        
      //Si estan activas las ventas lo dejo en true
      if ($parametro->getActivo() == 1) {
       $flagVentas=true;
      }
      else {
       $flagVentas=false;
      }
   
    //Guardo el estado en un array
    $arrayEstadoVentas=array("estadoVentas" => $flagVentas);  
    //Retorno el respose
    return new JsonResponse($arrayEstadoVentas);       
   }

   /**
   * @Route("/api/informacionTienda", name="api_informacion")
   */
    public function obtenerInformacion(): Response {
    //Obtengo el Entity Manager
    $em = $this ->getDoctrine()->getManager();  
    //Obtengo el mensaje quienes somos
    $mensajeHome=$em->getRepository(Configuracion::class)->find(1); 
    //Defino el mensaje
    $arrayInfoTienda="";
        
      //Si estan activas las ventas lo dejo en true
      if ($mensajeHome->getMensaje()) {
       $arrayInfoTienda=array("infoTienda" => $mensajeHome->getMensaje(),"estado" => $mensajeHome->getActivo());         
      }
      else {
       $arrayInfoTienda=array("infoTienda" => '',"estado" => $mensajeHome->getActivo());         
      }   
     
    //Retorno el respose
    return new JsonResponse($arrayInfoTienda);       
   }

   /**
   * @Route("/api/nombreTienda", name="api_obtener_nombre_tienda")
   */
    public function obtenerNombreTienda(): Response {
    //Obtengo el Entity Manager
    $em = $this ->getDoctrine()->getManager();  
    //Obtengo el mensaje quienes somos
    $mensaje=$em->getRepository(Configuracion::class)->find(2); 
    //Defino el mensaje
    $arrayInfoTienda="";
        
      //Si estan activas las ventas lo dejo en true
      if ($mensaje->getMensaje()) {
       $arrayInfoTienda=array("nombreTienda" => $mensaje->getMensaje());         
      }
      else {
       $arrayInfoTienda=array("nombreTienda" => 'Tienda');         
      }   
     
    //Retorno el respose
    return new JsonResponse($arrayInfoTienda);       
   }

   /**
   * @Route("/api/nroTienda", name="api_obtener_numero_tienda")
   */
    public function obtenerNumeroTienda(): Response {
    //Obtengo el Entity Manager
    $em = $this ->getDoctrine()->getManager();  
    //Obtengo el mensaje quienes somos
    $mensaje=$em->getRepository(Configuracion::class)->find(3); 
    //Defino el mensaje
    $arrayInfoTienda="";
        
      //Si estan activas las ventas lo dejo en true
      if ($mensaje->getMensaje()) {
       $arrayInfoTienda=array("numeroTienda" => $mensaje->getMensaje());         
      }
      else {
       $arrayInfoTienda=array("numeroTienda" => '');         
      }   
     
    //Retorno el respose
    return new JsonResponse($arrayInfoTienda);       
   }


//nombreTienda
}

