<?php

namespace App\Controller;

use App\Entity\Cesta;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $user = $this->getUser();
        if($user){

            $cesta = new Cesta();
            
            $em = $this->getDoctrine()->getManager();

            $cesta = $em->getRepository(Cesta::class)->buscarCestaPaginado();

            $pagination = $paginator->paginate(
                $cesta, /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                20 /*limit per page*/
            );

            return $this->render('home/index.html.twig', [
                'controller_name' => 'Cesta',
                'cesta' => $pagination
            ]);
        }else{
            return $this->redirectToRoute('app_login');
        }
        
    }

    /**
     * @Route("/updateCart", name="updateCart")
     */
    public function updateCart(Request $request){
        
        $cesta = new Cesta();
        $em = $this->getDoctrine()->getManager();  
        $parametros = $request->request->all();

        foreach($parametros as $id){
            if($id == "COMPRAR"){

            }
            else{
                $cesta = $em->getRepository(Cesta::class)->find($id);
                $cesta->setComprado(true);

                $em->persist($cesta);
                $em->flush();
            }
            
        }

        return $this->redirectToRoute('home');

    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(EntityManagerInterface $em, Cesta $cesta){

        $em->remove($cesta);
        $em->flush();

        return $this->redirectToRoute('home');
    }
}
