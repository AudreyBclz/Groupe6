<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Form\OrderType;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MenController extends AbstractController
{
    /**
     * @Route("/men", name="men")
     */

    public function index(PaginatorInterface $paginator, Request $request)
    {
        $lunettes=$this->getDoctrine()->getRepository(Product::class)->findByGender('Homme');

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
        return $this->render('men/index.html.twig', [
            'controller_name' => 'MenController',
            'pagination'=>$pagination,
            'tab_form'=>$tab_form
        ]);
    }

}
