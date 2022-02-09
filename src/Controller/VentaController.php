<?php

namespace App\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class VentaController extends AbstractController
{


   /**
   * Require ROLE_ADMIN for only this controller method.
   *
   * @Route("/app/ventas", name="venta_abm")
   *
   * @IsGranted("ROLE_ADMIN")
   */
   //Funcion para listar las ventas en el sistema 
   public function listarVentasAbm(): Response {
   //Obtengo el EntityManager
   $em= $this ->getDoctrine()->getManager(); 
   //Obtengo las ventas del sistema
   $ventas= $em->getRepository(Venta::class)->findAll();

    //Retorno a la vista
    return $this->render('Venta/gestionarVentas.html.twig', 
      [
       'ventas' => $ventas,
      ]
    );
  }

  /**
  *
  * @Route("/venta", name="venta")
  *
  */
  //Funcion para mostrar el detalle de una venta
  public function misCompras(): Response {
   //Obtengo el EntityManager
   $em = $this ->getDoctrine()->getManager();    
   //Obtengo el usuario logueado
   $usuarioLogueado=$this->get('security.token_storage')->getToken()->getUser();
   //Obtengo las compras del usuario
   $ventas= $usuarioLogueado->getVentas();
   
    //Retorno a la vista
    return $this->render('Venta/index.html.twig', 
      [
       'ventas' => $ventas,
      ]
    );
  }
    
  /**
  *
  * @Route("/app/venta/{idVenta}", name="venta_ver")
  *
  * @IsGranted("ROLE_USER")
  */
  //Funcion para mostrar el detalle de una venta
  public function verVenta($idVenta): Response {
   //Obtengo el EntityManager
   $em = $this ->getDoctrine()->getManager();    
   //Obtengo el usuario logueado
   $usuarioLogueado=$this->get('security.token_storage')->getToken()->getUser();
   //Obtengo todos los Productos que esten disponibles 
   $venta=$em->getRepository(Venta::class)->find($idVenta);

    
    //Si lo ve un administrador le permito ver la venta
    if($usuarioLogueado->isAdmin()) {
      
      //Retorno a la vista
      return $this->render('Venta/ver.html.twig', 
        [
         'venta' => $venta,
        ]
      );
    }
    //Si no es admin sigo por aca
    else {
      //Si el usuario de la venta es el usuario logueado le permito verlo
      if($usuarioLogueado == $venta->getUsuario()) {
        //Retorno a la vista
        return $this->render('Venta/ver.html.twig', 
          [
           'venta' => $venta,
          ]
        );
      }
      //Si encima no es el usuario logueado lo rajo
      else {
       //Aviso
       $this->addFlash('alerta','ERROR! No puede ver productos de otros usuarios');
       //Redirecciono al listado 
       return $this->redirectToRoute('home');
      }
    }    
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
   $productosCarrito=$usuarioLogueado->getCarrito()->getProductoscarrito();
   //Coleccion donde voy a almacenar mis articulos
   $articulosVenta = new ArrayCollection();
       
    foreach ($productosCarrito as $productoCarrito) {
     $articulosVenta->add($productoCarrito);
    }

   //Cargo la coleccion de productoscarrito a los articulos de la venta
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
