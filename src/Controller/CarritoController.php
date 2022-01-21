<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Producto;
use App\Entity\Carrito;

class CarritoController extends AbstractController
{
    /**
     * @Route("/carrito", name="carrito")
     */
    //Funcion para ver el carrito de compras del usuario logueado
    public function index(): Response
    {
     //Obtengo el EntityManager
     $em = $this ->getDoctrine()->getManager();
     //Obtengo el usuario logueado
     $usuarioLogueado=$this->get('security.token_storage')->getToken()->getUser();
     //Obtengo el Carrito de compras de mi usuario
     $carrito=$usuarioLogueado->getCarrito();

        //Si el carrito no existe lo creo por unica vez
        if(!$usuarioLogueado->getCarrito()) {
         $carrito=$this->crearCarrito($usuarioLogueado);         
        }
        
   
        //Retorno la vista
        return $this->render('carrito/index.html.twig', 
            [
             'carrito' => $carrito,
            ]
        );
    }

    //Funcion que me crea un carrito de compras en caso de que no exista
    private function crearCarrito($usuarioLogueado) {
     //Obtengo el EntityManager
     $entityManager = $this ->getDoctrine()->getManager();
     //Creo la entidad y le cargo los datos minimos
     $nuevoCarrito= new Carrito();
     $nuevoCarrito->setMonto(0);
     $nuevoCarrito->setUsuario($usuarioLogueado);   
     //Asigno el carrito al usuario logueado
     $usuarioLogueado->setCarrito($nuevoCarrito);  
     //Le doy persistencia 
     $entityManager->persist($nuevoCarrito);
     //Asiento los cambios en la base de datos
     $entityManager->flush();
     //Retorno mi carrito creado
     return $nuevoCarrito;
    }

    /**
    * @Route("/carrito/agregar/{idProducto}", name="carrito_agregar")
    */
    public function agregarProducto($idProducto): Response {
     //Obtengo el EntityManager
     $em = $this ->getDoctrine()->getManager();     
     //Obtengo el producto 
     $producto=$em->getRepository(Producto::class)->find($idProducto);
     //Obtengo el Usuario Logueado
     $usuarioLogueado=$this->get('security.token_storage')->getToken()->getUser();
     
        
        //Si el carrito no existe lo creo por unica vez
        if(!$usuarioLogueado->getCarrito()) {
         $carrito=$this->crearCarrito($usuarioLogueado);         
        }
        
     //Obtengo el Carrito de compras de mi usuario
     $carrito=$usuarioLogueado->getCarrito();   
     //Agrego el producto al carrito
     $carrito->addProducto($producto);
     //Calculo el nuevo monto a pagar
     $montoTotal=$carrito->getMonto() + $producto->getPrecio();
     //Actualizo el total a pagar del carrito 
     $carrito->setMonto($montoTotal);
     //Le doy persistencia 
     $em->persist($carrito);
     //Asiento los cambios en la base de datos
     $em->flush();

     //Retorno la vista al carrito
     return $this->redirectToRoute('carrito');
    }

    /**
    * @Route("/carrito/quitar/{idProducto}", name="carrito_quitar")
    */
    public function quitarProducto($idProducto): Response { 
     //Obtengo el EntityManager
     $em = $this ->getDoctrine()->getManager();     
     //Obtengo el Usuario Logueado
     $usuarioLogueado=$this->get('security.token_storage')->getToken()->getUser();
     //Obtengo el Carrito de compras de mi usuario
     $carrito=$usuarioLogueado->getCarrito();  
     //Obtengo el producto 
     $producto=$em->getRepository(Producto::class)->find($idProducto);  
     //Quito el producto del carrito
     $carrito->removeProducto($producto);    
     //Calculo el nuevo monto a pagar
     $montoTotal=$carrito->getMonto() - $producto->getPrecio();
     //Actualizo el monto a pagar
     $carrito->setMonto($montoTotal);
     //Le doy persistencia 
     $em->persist($carrito);
     //Asiento los cambios en la base de datos
     $em->flush();
     //Retorno la vista al carrito
     return $this->redirectToRoute('carrito');
    }





}
