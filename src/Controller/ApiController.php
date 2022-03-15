<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Parametro;
use App\Form\ParametroType;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/estadoVentas", name="api_ventas_estado")
     */
    public function index(): Response {
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
}

