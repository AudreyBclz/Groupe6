<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    /**
     * @Route("/admin/list", name="list",methods={"GET"})
     */

    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('admin/list/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }
}
