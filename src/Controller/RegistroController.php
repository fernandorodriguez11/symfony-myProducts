<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistroUsuarioType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistroController extends AbstractController
{
    /**
     * @Route("/registro", name="registro")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $mensaje = "";

        $user = new User();
        
        $form = $this->createForm(RegistroUsuarioType:: class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();

            //Codifico la contraseña
            $user->setPassword($passwordEncoder->encodePassword($user, $form['password']->getData()));

            $em->persist($user);
            $em->flush();

            //Pruebo esto si no utilizo  el addFlash
            $mensaje = "Usuario insertado correctamente";

            return $this->redirectToRoute("registro");
            /**
             * $this->addFlash('exito', USER::REGISTRO_EXITOSO);
             * return $this->redirectToRoute("registro");
             */
        }
        
        return $this->render('registro/index.html.twig', [
            'titulo_vista' => "Registro de Usuario",
            'formulario' => $form->createView(),
            'mensaje' => $mensaje
        ]);
    }
}
