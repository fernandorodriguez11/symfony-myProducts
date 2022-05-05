<?php

namespace App\Controller;

use App\Entity\Productos;
use App\Entity\Cesta;
use App\Form\ProductosType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductosController extends AbstractController
{
    /**
     * @Route("/insert-productos", name="productos")
     */
    public function index(Request $request, SluggerInterface $slugger)
    {
        $producto = new Productos();

        $form = $this->createForm(ProductosType::class, $producto);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $foto = $form['foto_producto']->getData();

            if($foto){

                $originalFileName = pathinfo($foto->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFileName = $slugger->slug($originalFileName);

                $newFileName = $safeFileName.'-'.uniqid().'.'.$foto->guessExtension();

                try{
                    $foto->move(
                        $this->getParameter('photos_directory'), $newFileName
                    );
                }
                catch(FileException $e){
                    throw new \Exception("Upsss ha ocurrido un error, sorry");
                }

                $producto->setFotoProducto($newFileName);
            }

            $em = $this->getDoctrine()->getManager();            

            $em->persist($producto);
            $em->flush();

            return $this->redirectToRoute('productos');

        }

        return $this->render('productos/index.html.twig', [
            'controller_name' => 'Insertar Producto',
            'formulario' => $form->createView(),
        ]);
    }

    /**
     * @Route("/cocina", name="cocina")
     */
    public function cocina(Request $request){

        $productos = new Productos();

        $usuario = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $productos = $em->getRepository(Productos::class)->findBy(['ubicacion_casa' => 'cocina']);

        $mensaje = '';
        if(!empty($_GET['mensaje'])){
            $mensaje = $_GET['mensaje'];
        }

        return $this->render('productos/cocina.html.twig', [
            'controller_name' => 'Cocina',
            'usuario' => $usuario->getUsername(),
            'productos_cocina' => $productos,
            'mensaje' => $mensaje
        ]);

    }

    /**
     * @Route("/casa", name="casa")
     */
    public function casa(Request $request){
        
        $productos = new Productos();

        $em = $this->getDoctrine()->getManager();

        $mensaje = '';
        if(!empty($_GET['mensaje'])){
            $mensaje = $_GET['mensaje'];
        }

        $productos = $em->getRepository(Productos::class)->findBy(['ubicacion_casa' => 'casa']);

        return $this->render('productos/casa.html.twig', [
            'controller_name' => 'Casa',
            'productos_casa' => $productos,
            'mensaje' => $mensaje
        ]);

    }

    /**
     * @Route("/lavabo", name="lavabo")
     */
    public function lavabo(Request $request){
        
        $productos = new Productos();

        $em = $this->getDoctrine()->getManager();

        $mensaje = '';
        if(!empty($_GET['mensaje'])){
            $mensaje = $_GET['mensaje'];
        }

        $productos = $em->getRepository(Productos::class)->findBy(['ubicacion_casa' => 'baño']);

        return $this->render('productos/lavabo.html.twig', [
            'controller_name' => 'Baño',
            'productos_lavabo' => $productos,
            'mensaje' => $mensaje
        ]);

    }

    /**
     * @Route("/addToCart", name="addToCart")
     */
    public function addToCart(Request $request){
        
        $cesta = new Cesta();
        $productos = new Productos();

        $id = $request->request->get('id');
        $opcion = $request->request->get('submit');

        $cantidad = intval($request->request->get('cantidad'.$id));
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();     
        //Obtengo el producto con el id de producto
        $productos = $em->getRepository(Productos::class)->find($id);

        $existe = $em->getRepository(Cesta::class)->findBy(['producto' => $id]);

        if(empty($existe)){
            // 'No hay ninguno en la cesta';
            //Inserto el producto_id, user_id, cantidad, comprado = false en la base de datos.
            $cesta->setProducto($productos);
            $cesta->setCantidad($cantidad);
            $cesta->setUser($user);
            $cesta->setComprado(false);

            $em->persist($cesta);
            $em->flush();
        }else{
            foreach($existe as $producto){
                //Si el producto aun no está comprado incremento la cantidad
                if($producto->getComprado() == 0){
                    $producto->setCantidad($producto->getCantidad() + $cantidad);
                }else if($producto->getComprado() == 1){
                    //si ya está comprado reinicio la cantidad a la nueva cantidad y pongo comprado a no. Esto sería si no se a eliminado de la cesta
                    //O crear uno nuevo y esperar que el otro se elimine
                    $producto->setCantidad($cantidad);
                    $producto->setComprado(false);
                }

                $em->persist($producto);
                $em->flush();
            }
        }

        return $this->redirectToRoute($opcion,['mensaje' => 'Exitoso']);

    }
    
}
