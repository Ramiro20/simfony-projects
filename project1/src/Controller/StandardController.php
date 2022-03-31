<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Entity\Categoria;
use App\Form\ProductoType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class StandardController extends AbstractController
{
     /**
     * @Route("/", name="index")
     */
    public function index(Request $request){
        $user= $this->getUser();
        if($user){
        $producto = new Producto();
        $form = $this->createForm(ProductoType::class,$producto);
        $n = 15554;
        $m = 125;
        $suma = $n+$m;
        $cad = "julio ever katherin";
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $producto = $form->getData();
            $em->persist($producto);
            $em->flush();
            return $this->redirectToRoute('index');
        }
        return $this->render('standard/index.html.twig',
            array(
                'Sumaentrenumeerounoydos'=>$suma,
                'nro1'=>$n,
                'nro2'=>$m,
                'nombres'=>$cad,
                'form'=>$form->createView()
                )
        );
        }else{
            return $this->redirectToRoute('fos_user_security_login');
        } 
    }

    /**
      * @Route("/pagina2/{nombre}" , name="pagina2")
      */
    public function pagina2(Request $request,$nombre){
        $form = $this->createFormBuilder()
          ->add('nombre')
          ->add('codigo')
          ->add('categoria', EntityType::class, [
            'class' => Categoria::class,
            'choice_label' => 'nombre'
          ])
          ->add('Enviar', SubmitType::class, array('label' => 'Enviar'))
          ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $data= $form->getData();
            $producto = new Producto($data['nombre'],$data['codigo']);
            $producto->setCategoria($data['categoria']);
            $em->persist($producto);
            $em->flush();
            return $this->redirectToRoute('pagina2',['nombre'=>'Guardado Exitoso']);
        }

        return $this->render('standard/pagina2.html.twig',array('parametro1'=>$nombre, 'form'=>$form->createView()));
    }

    /**
      * @Route("/lucky/number")
      */

    public function number()
    {
        $number = random_int(0, 100);

        /*return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );*/
        return $this->render('standard/number.html.twig',['number' => $number]);
    }

    /**
     * @Route("/PersistirDatos/",name="Persistir")
     */
    public function PersistDatos(){
        $entityManager = $this->getDoctrine()->getManager();
        $categoria = new Categoria('Tecnologia');
        $producto = new Producto('TV LCD 32','Tv-01');
        $producto->setCategoria($categoria);
        $entityManager->persist($producto);
        $entityManager->flush();
        return $this->render('standard/success.html.twig');
    }

    /**
     * @Route("/Busquedas/{idProducto}", name="Busquedas")
     */
    public function Busqueda($idProducto){
        $sd = $this->getDoctrine()->getManager();
        $producto = $sd->getRepository(Producto::class)->find(1);
        $producto2 = $sd->getRepository(Producto::class)->findOneBy(['codigo'=>'Tv-01','nombre'=>'TV PANTALLA PLANA']);
        $producto3 = $sd->getRepository(Producto::class)->findBy(['categoria'=>'1']);
        $productos = $sd->getRepository(Producto::class)->findAll();
        $productoRepository = $sd->getRepository(Producto::class)->BuscarProductoPorId($idProducto);
        return $this->render('standard/busqueda.html.twig' ,array(
            'find'=>$producto, 
            'findOneBy'=>$producto2,
            'findBy'=>$producto3,
            'findAll'=>$productos,
            'BuscarProductoPorId'=>$productoRepository
            ));
    }

}
