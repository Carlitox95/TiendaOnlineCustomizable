<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Producto;
use App\Entity\Carrito;
use App\Entity\Venta;
use App\Entity\Estadoventa;
use App\Entity\ProductosCarrito;
use App\Form\ProductosCarritoType;

class VentaController extends AbstractController
{
    /**
     * @Route("/venta", name="venta")
     */
    public function index(): Response
    {
        return $this->render('Venta/index.html.twig', [
            'controller_name' => 'VentaController',
        ]);
    }
    
    //Funcion que me crea un carrito de compras en caso de que no exista
    private function resetearCarrito($usuarioLogueado) {
     //Obtengo el EntityManager
     $entityManager = $this->getDoctrine()->getManager();
     //Obtengo el carrito
     $carrito= $usuarioLogueado->getCarrito();
     //Creo la entidad y le cargo los datos minimos
     $carrito->setMonto(0);
     //Obtengo todos los productos carrito para dejarlo vacio
     $productosCarrito=$carrito->getProductoscarrito();     
        
        //Quito uno a uno los productos del carrito
        foreach ($productosCarrito as $productoCarrito) {
         $carrito->removeProductoscarrito($productoCarrito);
        }
     
     //Le doy persistencia 
     $entityManager->persist($carrito);
     //Asiento los cambios en la base de datos
     $entityManager->flush();
     //Retorno mi carrito creado
     return $carrito;
    }

    //Funcion que me crea un carrito de compras en caso de que no exista
    private function crearVenta($usuarioLogueado) {
     //Obtengo el EntityManager
     $entityManager = $this ->getDoctrine()->getManager();
     //Creo la entidad y le cargo los datos minimos
     $nuevaVenta= new Venta();
     $nuevaVenta->setUsuario($usuarioLogueado); 
     $nuevaVenta->setFecha(new \DateTime());

     //Obtengo el estado Inicial de la Venta
     $estadoInicial= $entityManager->getRepository(Estadoventa::class)->find(1);
     $nuevaVenta->setEstado($estadoInicial);
     $estadoInicial->addVenta($nuevaVenta);
     
     //Le cargo los articulos del carrito de compras a la venta
     $articulosVenta=$usuarioLogueado->getCarrito()->getProductoscarrito();
     $nuevaVenta->setArticulos($articulosVenta);
     //Le calculo el valor a pagar por el total de la venta
     $precioVenta=$usuarioLogueado->getCarrito()->getMontoTotal();
     $nuevaVenta->setPrecio($precioVenta);
     //Asigno la venta al usuario logueado
     $usuarioLogueado->addVenta($nuevaVenta);  
     //Le doy persistencia 
     $entityManager->persist($nuevaVenta);
     //Asiento los cambios en la base de datos
     $entityManager->flush();
     //Retorno mi carrito creado
     return $nuevaVenta;
    }

    /**
    * @Route("/venta/nueva", name="venta_nueva")
    */
    //Funcion confirmar agregar un producto al carrito
    public function confirmarVenta(): Response {
     //Obtengo el EntityManager
     $entityManager = $this ->getDoctrine()->getManager();     
     //Obtengo el Usuario Logueado
     $usuarioLogueado=$this->get('security.token_storage')->getToken()->getUser();  
     //Creo la venta
     $venta=$this->crearVenta($usuarioLogueado);
     //Una vez creada debo resetear mi carrito de compras
     $carrito=$this->resetearCarrito($usuarioLogueado);
     $usuarioLogueado->setCarrito($carrito);
     
     //Asiento los cambios en la base de datos
     $entityManager->flush();     

        //Retorno la vista
        return $this->render('Venta/confirmar.html.twig', 
            [
             'venta' => $venta,             
            ]
        );
  }














}
