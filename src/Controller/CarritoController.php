<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Producto;
use App\Entity\Carrito;
use App\Entity\ProductosCarrito;
use App\Form\ProductosCarritoType;

class CarritoController extends AbstractController
{
   /**
  * @Route("/carrito", name="carrito")
  */
  //Funcion para ver el carrito de compras del usuario logueado
  public function index(): Response {
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
    return $this->render('Carrito/index.html.twig', 
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
  
  //Funcion que valida el stock de un Producto antes de comprar
  private function validarStockProducto($unProducto,$unaCantidad) {
    if($unProducto->getStock() >= $unaCantidad ) {
     return true;
    }
    else {
     return false;
    }
  }


  /**
  * @Route("/carrito/agregar/{idProducto}", name="carritoproductos_agregar")
  */
  //Funcion confirmar agregar un producto al carrito
  public function agregarProductoCarrito($idProducto): Response {
   //Obtengo el EntityManager
   $em = $this ->getDoctrine()->getManager();     
   //Obtengo el producto 
   $producto=$em->getRepository(Producto::class)->find($idProducto);
   //Obtengo el Usuario Logueado
   $usuarioLogueado=$this->get('security.token_storage')->getToken()->getUser();  
   //Obtengo el Carrito de compras de mi usuario
   $carrito=$usuarioLogueado->getCarrito();  

    //Si el carrito no existe lo creo por unica vez
    if(!$usuarioLogueado->getCarrito()) {
     $carrito=$this->crearCarrito($usuarioLogueado);         
    }

    //Retorno la vista
    return $this->render('Carrito/confirmar.html.twig', 
      [
       'producto' => $producto,
       'carrito' => $carrito,             
      ]
    );
  }
     

    /**
    * @Route("/carrito/confirmar", name="carritoproductos_confirmar" , methods={"POST"})
    */
    public function confirmarProductoCarrito(Request $request): Response {
     //Obtengo el EntityManager
     $em= $this->getDoctrine()->getManager();
     //Obtengo los valores del Formulario via Post
     $productoId=$request->request->get('productoId');
     $carritoId=$request->request->get('carritoId');
     $cantidadProducto=$request->request->get('cantidadProducto');
     //Obtengo las entidades a partir de los parametros
     $producto=$em->getRepository(Producto::class)->find($productoId);
     $carrito=$em->getRepository(Carrito::class)->find($carritoId);
     

      //Si el stock es suficiente para la comprar la permito
      if($this->validarStockProducto($producto,$cantidadProducto) == true ) {
       //Creo la entidad Intermedia entre Carrito y Producto
       $productoEnCarrito=new ProductosCarrito();
       $productoEnCarrito->setProducto($producto);
       $productoEnCarrito->setCarrito($carrito);
       $productoEnCarrito->setCantidad($cantidadProducto);
       //Agrego el producto y su cantidad al carrito de compras
       $carrito->addProductoscarrito($productoEnCarrito);
       //Le doy persistencia 
       $em->persist($productoEnCarrito);
       //Asiento los cambios en la base de datos
       $em->flush();
       //Aviso
       $this->addFlash('exito','Producto Agregado al Carrito de compras');
       //Retorno la vista al carrito
       return $this->redirectToRoute('carrito');
      }
      else {
       $this->addFlash('aviso','No se pudo agregar el producto por falta de Stock');
       //Retorno la vista al carrito
       return $this->redirectToRoute('carrito');
      }
    }


  /**
  * @Route("/carrito/quitar", name="carrito_quitar" , methods={"POST"})
  */
  public function quitarProducto(Request $request): Response { 
   //Obtengo el EntityManager
   $em = $this ->getDoctrine()->getManager();     
   //Obtengo el Usuario Logueado
   $usuarioLogueado=$this->get('security.token_storage')->getToken()->getUser();
   //Obtengo el Carrito de compras de mi usuario
   $carrito=$usuarioLogueado->getCarrito(); 
   //Obtengo los parametros del Request
   $productoId=$request->request->get('productoId');
   $productoCarritoId=$request->request->get('productoCarritoId');

   //Obtengo las entidades
   $producto=$em->getRepository(Producto::class)->find($productoId); 
   $productosCarrito=$em->getRepository(ProductosCarrito::class)->find($productoCarritoId);
   
 
    //Si hay mas de 1 , resto 1 , sino directamente elimino el producto
    if($productosCarrito->getCantidad() > 1) {
     //Determino la nueva cantidad
     $cantidadActual=$productosCarrito->getCantidad();
     $nuevaCantidad=$cantidadActual - 1;
     $productosCarrito->setCantidad($nuevaCantidad);
     //Le doy persistencia 
     $em->persist($productosCarrito);
     //Asiento los cambios en la base de datos
     $em->flush();
     //Infomo
     $this->addFlash('exito','Se elimino una unidad del producto');
    }
    else {
     //Si era el unico quito la entidad ProductosCarrito directamente
     $carrito->removeProductoscarrito($productosCarrito);
     //Le doy persistencia 
     $em->persist($carrito);
     //Asiento los cambios en la base de datos
     $em->flush();
     //Infomo
     $this->addFlash('exito','Se elimino una unidad del producto');
    }  
   //Retorno la vista al carrito
   return $this->redirectToRoute('carrito');
  }

  /**
  * @Route("/carrito/agregar", name="carrito_agregar" , methods={"POST"})
  */
  public function agregarProductoExistente(Request $request): Response { 
   //Obtengo el EntityManager
   $em = $this ->getDoctrine()->getManager();     
   //Obtengo el Usuario Logueado
   $usuarioLogueado=$this->get('security.token_storage')->getToken()->getUser();
   //Obtengo el Carrito de compras de mi usuario
   $carrito=$usuarioLogueado->getCarrito(); 
   //Obtengo los parametros del Request
   $productoId=$request->request->get('productoId');
   $productoCarritoId=$request->request->get('productoCarritoId');

   //Obtengo las entidades
   $producto=$em->getRepository(Producto::class)->find($productoId); 
   $productosCarrito=$em->getRepository(ProductosCarrito::class)->find($productoCarritoId);
   
   //Determino la nueva cantidad
   $cantidadActual=$productosCarrito->getCantidad();
   $nuevaCantidad=$cantidadActual + 1;
   
    
    //Si el stock me lo permite aumento la cantidad
    if($this->validarStockProducto($producto,$nuevaCantidad) == true ) {
     $productosCarrito->setCantidad($nuevaCantidad);
     //Le doy persistencia 
     $em->persist($productosCarrito);
     //Asiento los cambios en la base de datos
     $em->flush();
     //Infomo
     $this->addFlash('exito','Se agrego una unidad adicional');
    }
    else {
     //Infomo
     $this->addFlash('aviso','No hay stock suficiente!');
    }
   
   //Retorno la vista al carrito
   return $this->redirectToRoute('carrito');
  }





}
