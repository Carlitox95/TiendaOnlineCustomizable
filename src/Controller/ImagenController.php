<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Entity\Imagen;

class ImagenController extends AbstractController
{


    /**
    * Require ROLE_ADMIN for only this controller method.
    * 
    * @Route("/app/imagen/eliminar/{idImagen}", name="imagen_eliminar")
    * 
    * @IsGranted("ROLE_ADMIN")
    */
    public function eliminarImagenProducto($idImagen): Response {
     //Obtengo el EntityManager
     $em= $this->getDoctrine()->getManager();   
     //Obtengo las entidades a partir de los parametros
     $imagen=$em->getRepository(Imagen::class)->find($idImagen);
     //Obtengo el producto
     $producto=$imagen->getProducto();
     //Obtengo la Url
     $urlImagen=$imagen->getUrl();
     //Elimino la imagen Fisicamente en el FileSistem
     unlink($urlImagen);
     //Elimino la Imagen Logicamente en la base de datos
     $producto->removeImagen($imagen);
     $em->remove($imagen);
     //Le doy persistencia 
     $em->persist($producto);
     //Asiento los cambios en la base de datos
     $em->flush();
     //Redirecciono al listado 
     return $this->redirectToRoute('producto_abm');
    }
}
