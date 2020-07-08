<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WomenController extends AbstractController
{
    /**
     * @Route("/women", name="women")
     */
    public function index(ProductRepository $productRepository, PaginatorInterface $paginator, Request $request)
    {
        $lunettes=$this->getDoctrine()->getRepository(Product::class)->findByGender('Femme');

        $pagination= $paginator->paginate(
            $lunettes, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );
        return $this->render('women/index.html.twig', [
            'controller_name' => 'WomenController',
            'pagination'=>$pagination
        ]);
    }
}
