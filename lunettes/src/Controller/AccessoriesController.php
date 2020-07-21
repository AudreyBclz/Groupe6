<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Form\OrderType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AccessoriesController extends AbstractController
{
    /**
     * @Route("/accessories", name="accessories")
     */

    public function index(Request $request,PaginatorInterface $paginator)
    {
        $lunettes=$this->getDoctrine()->getRepository(Product::class)->findByCat('Accessory');

        $pagination= $paginator->paginate(
            $lunettes, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );
        $order=new Order();
        $tab_form=array();
        foreach ($pagination as $pag)
        {
            $form=$this->createForm(OrderType::class,$order);
            $form->handleRequest($request);
            array_push($tab_form,$form->createView());
        }
        return $this->render('accessories/index.html.twig', [
            'controller_name' => 'AccessoriesController',
            'tab_form'=>$tab_form,
            'pagination'=>$pagination
        ]);
    }
}
