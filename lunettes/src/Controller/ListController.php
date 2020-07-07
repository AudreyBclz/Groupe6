<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    /**
     * @Route("/admin/list", name="list",methods={"GET"})
     */

    public function index(ProductRepository $productRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $lunettes = $productRepository->findAll();

        $pagination = $paginator->paginate(
            $lunettes, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('admin/list/index.html.twig', [
            'pagination' => $pagination
        ]);
    }
}
