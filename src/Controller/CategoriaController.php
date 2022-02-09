<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Entity\Categoria;
use App\Form\CategoriaType;

class CategoriaController extends AbstractController
{
    /**
     * Require ROLE_ADMIN for only this controller method.
     * 
     * @Route("/app/categoria", name="categoria")
     * 
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(): Response
    {
     //Obtengo el EntityManager
     $em = $this ->getDoctrine()->getManager();    
     //Obtengo todos los Productos que esten disponibles 
     $categorias=$em->getRepository(Categoria::class)->findAll();

        //Retorno la vista
        return $this->render('Categoria/index.html.twig', [
            'categorias' => $categorias,
        ]);
    }


    /**
     * Require ROLE_ADMIN for only this controller method.
     * 
     * @Route("/app/categoria/ver/{idCategoria}", name="categoria_ver")
     * 
     * @IsGranted("ROLE_ADMIN")
     */
    public function verCategoria($idCategoria): Response {
     //Obtengo el EntityManager
     $em = $this ->getDoctrine()->getManager();     
     //Obtengo la categoria a mostrar
     $categoria=$em->getRepository(Categoria::class)->find($idCategoria);

        //Retorno a la vista
        return $this->render('Categoria/ver.html.twig', 
            [
             'categoria' => $categoria,
            ]
        );
    }

    /**
    * Require ROLE_ADMIN for only this controller method.
    *
    * @Route("/app/categoria/nuevo", name="categoria_nueva")
    *
    * @IsGranted("ROLE_ADMIN")
    */    
    public function nuevaCategoria(Request $request,SluggerInterface $slugger): Response {
     //Creo un nuevo Producto 
     $categoria = new Categoria(); 
     //Defino el Formulario
     $form = $this->createForm(CategoriaType::class, $categoria);
     //Si se envia el formulario , existe un request
     $form->handleRequest($request);

        //Si se disparo el formulario y es valido
        if ($form->isSubmitted() && $form->isValid()) {
         //Obtengo el EntityManager
         $entityManager = $this->getDoctrine()->getManager();
         //Obtengo el formulario
         $categoria= $form->getData(); 
         //Le doy persistencia 
         $entityManager->persist($categoria);
         //Asiento los cambios en la base de datos
         $entityManager->flush();
         //Redirecciono al listado 
         return $this->redirectToRoute('categoria');
        }

        //Retorno la vista
        return $this->render('Categoria/nueva.html.twig', 
            [             
             'form' => $form->createView(),             
            ]
        );   
    }


    /**
    * Require ROLE_ADMIN for only this controller method.
    * 
    * @Route("/app/categoria/editar/{idCategoria}", name="categoria_editar", methods={"GET","HEAD","POST"})
    * 
    * @IsGranted("ROLE_ADMIN")
    */
    //Funcion para editar una categoria
    public function editarCategoria($idCategoria,Request $request,SluggerInterface $slugger): Response {
     //Obtengo el EntityManager
     $entityManager=$this->getDoctrine()->getManager();
     //Obtengo la categoria seleccionado
     $categoria=$entityManager->getRepository(Categoria::class)->find($idCategoria);   
     //Defino el Formulario
     $form = $this->createForm(CategoriaType::class,$categoria);
     //Si se envia el formulario , existe un request
     $form->handleRequest($request);

        //Si se disparo el formulario y es valido
        if ($form->isSubmitted() && $form->isValid()) {
         //Obtengo la categoria del formulario
         $categoria = $form->getData();  
         //Obtengo el EntityManager
         $entityManager = $this->getDoctrine()->getManager();
         //Le doy persistencia 
         $entityManager->persist($categoria);
         //Asiento los cambios en la base de datos
         $entityManager->flush();
         //Redirecciono al listado 
         return $this->redirectToRoute('categoria');
        }

        //Redirecciono a la vista      
        return $this->render('Categoria/editar.html.twig', 
            [
             'form' => $form->createView(),
             'categoria' => $categoria,
            ]
        );
    }


}
