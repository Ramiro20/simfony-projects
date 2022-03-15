<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Entity\Categoria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StandardController extends AbstractController
{
     /**
     * @Route("/", name="index")
     */
    public function index(){
        $n = 15554;
        $m = 125;
        $suma = $n+$m;
        $cad = "julio ever katherin";
        return $this->render('standard/index.html.twig',
            array(
                'Sumaentrenumeerounoydos'=>$suma,
                'nro1'=>$n,
                'nro2'=>$m,
                'nombres'=>$cad)
        ); 
    }

    /**
      * @Route("/pagina2/{nombre}" , name="pagina2")
      */
    public function pagina2($nombre){
        return $this->render('standard/pagina2.html.twig',array('parametro1'=>$nombre));
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
        $producto = new Producto('TV LCD 32','Tv-02');
        $producto->setCategoria($categoria);
        $entityManager->persist($producto);
        $entityManager->flush();
        return $this->render('standard/success.html.twig');
    }

}
