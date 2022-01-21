<?php
namespace App\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UserType;
use App\Form\UserRolesType;
use App\Form\UserCambiarPasswordType;
use App\Form\UserCambiarMailType;
use App\Entity\User;


class UserController extends AbstractController {

    /**
     * @Route("/app/usuarios/", name="user")
     */
    //Funcion para listar el index del modulo personas
    public function index(): Response {
     //Obtengo el Entity Manager
     $em = $this ->getDoctrine()->getManager();     
     //Obtengo el usuario logueado
     $usuarioLogueado=$this->get('security.token_storage')->getToken()->getUser();

     //Obtengo mi usuario de la BD
     $usuario=$em->getRepository(User::class)->find($usuarioLogueado->getId());

     //$usuario=$em->getRepository(User::class)->findOneBy(['username' => $usuarioLogueado->getUserName()]);    
     
        //Retorno la vista
        return $this->render('User/index.html.twig', 
        	[             
             'usuario' => $usuario,
            ]
        );
    }


    /**
     * @Route("/app/usuarios/editarMail/", name="user_editar_mail", methods={"GET","HEAD","POST"})
     */
    //Funcion para editar los datos de una persona
    public function editarMailUsuario(Request $request): Response {
     //Obtengo el EntityManager
     $em = $this ->getDoctrine()->getManager();     
     //Obtengo el usuario logueado
     $usuarioLogueado=$this->get('security.token_storage')->getToken()->getUser();
     //Obtengo mi usuario de la BD
     $usuario=$em->getRepository(User::class)->find($usuarioLogueado->getId()); 
      
     //Defino el Formulario
     $form = $this->createForm(UserCambiarMailType::class, $usuario);  

     //Si se envia el formulario , existe un request
     $form->handleRequest($request);
       
       //Si se disparo el formulario y es valido
        if ($form->isSubmitted() && $form->isValid()) {
         //Obtengo el alumno del formulario
         $usuario = $form->getData();
         //Obtengo el EntityManager
         $entityManager = $this->getDoctrine()->getManager();
         //Le doy persistencia a la persona nueva
         $entityManager->persist($usuario);
         //Asiento los cambios en la base de datos
         $entityManager->flush();

         //Redirecciono al listado de personas
         return $this->redirectToRoute('user');
        }
      
        return $this->render('User/editar.html.twig', [
         'form' => $form->createView(),
         'usuario' => $usuario,
        ]);
    }

    /**
     * @Route("/app/usuarios/cambiarPassword/", name="user_editar_password", methods={"GET","HEAD","POST"})
     */
    //Funcion para editar los datos de una persona
    public function editarPasswordUsuario(Request $request): Response {
     //Obtengo el EntityManager
     $em = $this ->getDoctrine()->getManager();     
     //Obtengo el usuario logueado
     $usuarioLogueado=$this->get('security.token_storage')->getToken()->getUser();
     //Obtengo mi usuario de la BD
     $usuario=$em->getRepository(User::class)->find($usuarioLogueado->getId());
     //Defino el Formulario
     $form = $this->createForm(UserCambiarPasswordType::class, $usuario);  

     //Si se envia el formulario , existe un request
     $form->handleRequest($request);
       
       //Si se disparo el formulario y es valido
        if ($form->isSubmitted() && $form->isValid()) {
         //Obtengo el alumno del formulario
         $usuario = $form->getData();
         //Obtengo el EntityManager
         $entityManager = $this->getDoctrine()->getManager();
         //Le doy persistencia a la persona nueva
         $entityManager->persist($usuario);
         //Asiento los cambios en la base de datos
         $entityManager->flush();

         //Redirecciono al listado de personas
         return $this->redirectToRoute('user');
        }
        
        //Retorno a la vista
        return $this->render('User/editar.html.twig', [
         'form' => $form->createView(),
         'usuario' => $usuario,
        ]);
    }


    /**
      * Require ROLE_ADMIN for only this controller method.
      *
      * @Route("/app/users/", name="abm_usuarios")
      *
      * @IsGranted("ROLE_ADMIN")
      */
    //Funcion que muestra el panel de Administracion de los Usuarios
    public function abmUsuarios(): Response {
     //Obtengo el EntityManager
     $em = $this ->getDoctrine()->getManager();     
     //Obtengo mi usuario de la BD
     $usuarios=$em->getRepository(User::class)->findAll();

        //Retorno a la vista
        return $this->render('User/panelUsuarios.twig', [
         'usuarios' => $usuarios,
        ]);          
    }


    /**
      * Require ROLE_ADMIN for only this controller method.
      *
      * @Route("/app/users/editar/{idUser}", name="editarUsuario" , methods={"GET","HEAD","POST"})
      *
      * @IsGranted("ROLE_ADMIN")
      */
    //Funcion que me permite editar un usuario
    public function abmEditarUsuario($idUser,Request $request): Response {
     ///Obtengo el EntityManager
     $entityManager=$this->getDoctrine()->getManager();
     //Obtengo el usuario seleccionado
     $usuario=$entityManager->getRepository(User::class)->find($idUser);   
     //Defino el Formulario
     $form = $this->createForm(UserRolesType::class, $usuario);

     //Si se envia el formulario , existe un request
     $form->handleRequest($request);
       
       //Si se disparo el formulario y es valido
        if ($form->isSubmitted() && $form->isValid()) {
         //Obtengo el alumno del formulario
         $usuario = $form->getData();
         //Obtengo el EntityManager
         $entityManager = $this->getDoctrine()->getManager();
         //Le doy persistencia a la persona nueva
         $entityManager->persist($usuario);
         //Asiento los cambios en la base de datos
         $entityManager->flush();

         //Redirecciono al listado de personas
         return $this->redirectToRoute('abm_usuarios');
        }
        
        //Retorno a la vista
        return $this->render('User/panelEditarUsuario.html.twig', [
         'form' => $form->createView(),
         'usuario' => $usuario,
        ]);
    }    


}