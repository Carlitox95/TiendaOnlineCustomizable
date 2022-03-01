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


class AdministracionController extends AbstractController {

  /**
  * @Route("/app/administracion/", name="admin")
  *  
  * @IsGranted("ROLE_ADMIN")
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
    return $this->render('Administracion/index.html.twig', 
     	[             
       'usuario' => $usuario,
      ]
    );
  }

   


}