<?php

namespace App\Controller;


use Symfony\Component\Security\Core\Exception\AccessDeniedException; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Entity\Producto;
use App\Entity\Imagen;
use App\Form\ProductoType;
use App\Form\ProductoCategoriaType;
use App\Form\ProductoCategoriasType;


class ProductoController extends AbstractController
{
  /**
  * @Route("/producto", name="producto")
  */
  public function index(): Response {
   //Obtengo el EntityManager
   $em = $this ->getDoctrine()->getManager();    
   //Obtengo todos los Productos que esten disponibles 
   $productos=$em->getRepository(Producto::class)->findByProductosDisponibles();
   //$productos=$em->getRepository(Producto::class)->findBy(['activo' => '1'],['destacado'=> 'DESC']);

    //Retorno a la vista
    return $this->render('Producto/index.html.twig', 
      [
       'productos' => $productos,
      ]
    );
  }


  /**
  * Require ROLE_ADMIN for only this controller method.
  *
  * @Route("/app/gestionProductos", name="producto_abm")
  *
  * @IsGranted("ROLE_ADMIN")
  */
  //Funcion para listar todos los productos disponibles
  public function listarProductosAbm(): Response {
   //Obtengo el EntityManager
   $em = $this ->getDoctrine()->getManager();    
   //Obtengo todos los Productos que esten disponibles 
   $productos=$em->getRepository(Producto::class)->findAll();
   
    //Retorno a la vista
    return $this->render('Producto/gestionar.html.twig', 
      [
       'productos' => $productos,
      ]
    );
  }


  /**
  * @Route("/producto/ver/{idProducto}", name="producto_ver")
  */
  public function verProducto($idProducto): Response {
   //Obtengo el EntityManager
   $em = $this ->getDoctrine()->getManager();     
   //Obtengo el producto a mostrar
   $producto=$em->getRepository(Producto::class)->find($idProducto);

    //Retorno a la vista
    return $this->render('Producto/ver.html.twig', 
      [
       'producto' => $producto,
      ]
    );
  }

  /**
  * Require ROLE_ADMIN for only this controller method.
  *
  * @Route("/app/producto/ver/{idProducto}", name="producto_ver_abm")
  *
  * @IsGranted("ROLE_ADMIN")
  */
  //Funcion para listar todos los productos disponibles
  public function verProductoAbm($idProducto): Response {
   //Obtengo el EntityManager
   $em = $this ->getDoctrine()->getManager();     
   //Obtengo el producto a mostrar
   $producto=$em->getRepository(Producto::class)->find($idProducto);

    //Retorno a la vista
    return $this->render('Producto/verAbm.html.twig', 
      [
       'producto' => $producto,
      ]
    );
  }

   
  /**
  * Require ROLE_ADMIN for only this controller method.
  *
  * @Route("/app/productos/nuevo", name="producto_nuevo")
  *
  * @IsGranted("ROLE_ADMIN")
  */
  //Funcion para crear un producto
  public function nuevoProducto(Request $request,SluggerInterface $slugger): Response {
   //Creo un nuevo Producto 
   $producto = new Producto(); 
   //Defino el Formulario
   $form = $this->createForm(ProductoType::class, $producto);
   //Si se envia el formulario , existe un request
   $form->handleRequest($request);

    //Si se disparo el formulario y es valido
    if ($form->isSubmitted() && $form->isValid()) {
     //Obtengo el EntityManager
     $entityManager = $this->getDoctrine()->getManager();
     //Obtengo el producto del formulario
     $producto= $form->getData(); 
     //Obtengo la imagen que subi del producto  
     $imagenSubida= $form->get('imagen')->getData();
                        
      //Si existe la imagen la trabajo para guardarla
      if ($imagenSubida) {
       //Obtengo el Nombre Original de la Imagen para incluir de forma seguro el nombre de archivo en la URL
       $nombreOriginalImagen= pathinfo($imagenSubida->getClientOriginalName(), PATHINFO_FILENAME); 
       //Es necesario para incluir de forma segura el nombre del archivo como parte de la URL (todo minusculas)
       $nombreSeguroArchivo=strtolower($slugger->slug($nombreOriginalImagen));
       //Defino la URL completa de mi imagen subida
        $urlImagen= 'img/producto/'.$producto->getId().'/'.$nombreSeguroArchivo.'.'.$imagenSubida->guessExtension();

        try {
         //Muevo el archivo al directorio donde los almaceno
         $imagenSubida->move($this->getParameter('imagenes_directory')."/".$producto->getId(),$urlImagen);
         //Creo la nueva entidad imagen..
         $imagen = new Imagen(); 
         //Asigno los datos a la imagen
         $imagen->setUrl($urlImagen);
         $imagen->setProducto($producto);
         $imagen->setNombre($nombreOriginalImagen);
         //Inserto mi imagen a las imagenes del Producto
         $producto->addImagen($imagen);
         //Le doy persistencia a la imagen
         $entityManager->persist($imagen);
         //Aviso
         $this->addFlash('exito','Se ha cargado la imagen correctamente y crear el producto');
        } 
        catch (FileException $e) {
         $this->addFlash('aviso','Error al cargar la imagen');
         //Redirecciono al listado          
         return $this->redirectToRoute('producto_abm');
        }             
      }
        
     //Le doy persistencia 
     $entityManager->persist($producto);
     //Asiento los cambios en la base de datos
     $entityManager->flush();
     //Aviso
     $this->addFlash('exito','El producto se creo correctamente');
     //Redirecciono al listado 
     return $this->redirectToRoute('producto_abm');
    }

    //Retorno la vista
    return $this->render('Producto/nuevo.html.twig', 
      [             
       'form' => $form->createView(),             
      ]
    );   
  }
     
  /**
  * Require ROLE_ADMIN for only this controller method.
  * 
  * @Route("/app/productos/editar/{idProducto}", name="producto_editar", methods={"GET","HEAD","POST"})
  * 
  * @IsGranted("ROLE_ADMIN")
  */
  //Funcion para editar los datos de un producto
  public function editarProducto($idProducto,Request $request,SluggerInterface $slugger): Response {
   //Obtengo el EntityManager
   $entityManager=$this->getDoctrine()->getManager();
   //Obtengo el producto seleccionado
   $producto=$entityManager->getRepository(Producto::class)->find($idProducto);   
   //Defino el Formulario
   $form = $this->createForm(ProductoType::class, $producto);
   //Si se envia el formulario , existe un request
   $form->handleRequest($request);


    //Si se disparo el formulario y es valido
    if ($form->isSubmitted() && $form->isValid()) {
     //Obtengo el producto del formulario
     $producto = $form->getData();
     //Obtengo la imagen que subi del producto  
     $imagenSubida= $form->get('imagen')->getData();

      //Si existe la imagen la trabajo para guardarla
      if ($imagenSubida) {
       //Obtengo el Nombre Original de la Imagen para incluir de forma seguro el nombre de archivo en la URL
       $nombreOriginalImagen= pathinfo($imagenSubida->getClientOriginalName(), PATHINFO_FILENAME); 
       //Es necesario para incluir de forma segura el nombre del archivo como parte de la URL (todo en minusculas)
       $nombreSeguroArchivo=strtolower($slugger->slug($nombreOriginalImagen));
       //Defino la URL completa de mi imagen subida
       $urlImagen= 'img/producto/'.$producto->getId().'/'.$nombreSeguroArchivo.'.'.$imagenSubida->guessExtension();

        try {
         //Muevo el archivo al directorio donde los almaceno
         $imagenSubida->move($this->getParameter('imagenes_directory')."/".$producto->getId(),$urlImagen);
         //Creo la nueva entidad imagen..
         $imagen = new Imagen(); 
         //Asigno los datos a la imagen
         $imagen->setUrl($urlImagen);
         $imagen->setProducto($producto);
         $imagen->setNombre($nombreOriginalImagen);
         //Inserto mi imagen a las imagenes del Producto
         $producto->addImagen($imagen);
         //Le doy persistencia a la imagen
         $entityManager->persist($imagen);    
        } 
        catch (FileException $e) {
         $this->addFlash('aviso','Error al cargar la imagen');
         //Redirecciono al listado 
         return $this->redirectToRoute('producto');
        }             
      }
     
     //aviso
     $this->addFlash('exito','Se edito el producto correctamente');
     //Obtengo el EntityManager
     $entityManager = $this->getDoctrine()->getManager();
     //Le doy persistencia 
     $entityManager->persist($producto);
     //Asiento los cambios en la base de datos
     $entityManager->flush();     
     //Redirecciono al listado 
     return $this->redirectToRoute('producto_abm');
    }

    //Redirecciono a la vista      
    return $this->render('Producto/editar.html.twig', 
      [
       'form' => $form->createView(),
       'producto' => $producto,
      ]
    );
  }

  /**
  * Require ROLE_ADMIN for only this controller method.
  * 
  * @Route("/app/productos/categorizar/{idProducto}", name="producto_categoria", methods={"GET","HEAD","POST"})
  * 
  * @IsGranted("ROLE_ADMIN")
  */
  //Funcion para editar los datos de un producto
  public function categorizarProducto($idProducto,Request $request,SluggerInterface $slugger): Response {
   //Obtengo el EntityManager
   $entityManager=$this->getDoctrine()->getManager();
   //Obtengo el producto seleccionado
   $producto=$entityManager->getRepository(Producto::class)->find($idProducto);   
   //Defino el Formulario
   $form = $this->createForm(ProductoCategoriaType::class, $producto);
   //Si se envia el formulario , existe un request
   $form->handleRequest($request);

    //Si se disparo el formulario y es valido
    if ($form->isSubmitted() && $form->isValid()) {
     //Obtengo el producto del formulario
     $producto = $form->getData();

     //Le doy persistencia 
     $entityManager->persist($producto);
     //Asiento los cambios en la base de datos
     $entityManager->flush();
     //Aviso
     $this->addFlash('aviso','Se actualizaron las categorias');        
     //Redirecciono al listado 
     return $this->redirectToRoute('producto_abm');
    }

    //Redirecciono a la vista      
    return $this->render('Producto/categorizar.html.twig', 
      [
       'form' => $form->createView(),
       'producto' => $producto,
      ]
    );
  }


  /**
  * Require ROLE_ADMIN for only this controller method.
  * 
  * @Route("/app/productos/galeria/{idProducto}", name="producto_imagenes", methods={"GET","HEAD","POST"})
  * 
  * @IsGranted("ROLE_ADMIN")
  */
  public function editarImagenesProducto($idProducto,Request $request,SluggerInterface $slugger): Response {
   //Obtengo el EntityManager
   $entityManager=$this->getDoctrine()->getManager();
   //Obtengo el producto seleccionado
   $producto=$entityManager->getRepository(Producto::class)->find($idProducto);   
   
    //Redirecciono a la vista      
    return $this->render('Producto/editarImagenes.html.twig', 
      [
       'producto' => $producto,
      ]
    );
  }

}
