<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Form\OrderType;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $lunettes=$productRepository->findAll();

        $order= new Order();
        $form=$this->createForm(OrderType::class,$order);
        $form->handleRequest($request);

        $pagination= $paginator->paginate(
            $lunettes, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );
        return $this->render('product/index.html.twig', [
            'controller_name'=>'ProductController',
            'pagination'=>$pagination,
            'formorder'=>$form->createView()
        ]);
    }

    /**
    * @Route("/profile/order/{id}", name="order", methods={"GET","POST"})
     */

    public function order(ProductRepository $product,int $id , Request $request, PaginatorInterface $paginator)
    {
        $lunettes=$product->findAll();

        $pagination= $paginator->paginate(
            $lunettes, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );

        $msgOk='';
        $msgError="";
        $order= new Order();
        $prod=$product->find($id);
        $order->setNameProductOrder($prod->getNameProduct());
        $order->setPriceProductOrder($prod->getPriceProduct());
        $order->setProduct($prod);
        $user=$this->getUser();
        $order->setUser($user);
        $form=$this->createForm(OrderType::class,$order);
        $form->handleRequest($request);
        $inorder=$this->getDoctrine()->getRepository(Order::class)->findOneBy(["user"=>$order->getUser(),"product"=>$order->getProduct()]);

        if (!empty($inorder))
        {
            $qte1=$order->getQuantityProductOrder();
            $qte2=$inorder->getQuantityProductOrder();
            $qte=$qte1+$qte2;

            if($qte<= $prod->getStockProduct())
            {
                $order=$this->getDoctrine()->getRepository(Order::class)->findOneBy(["user"=>$order->getUser(),"product"=>$order->getProduct()]);
                $order->setQuantityProductOrder($qte);
                $this->getDoctrine()->getManager()->flush();
                $msgOk='Article(s) ajouté(s) au panier.';
                return $this->render('product/index.html.twig', [
                    'controller_name'=>'ProductController',
                    'pagination'=>$pagination,
                    'formorder'=>$form->createView(),
                    'msgOk'=>$msgOk,
                    'msgError'=>$msgError
                ]);


            }
            else
            {
                $msgError='Quantité supérieur au stock, réessayer.';
                return $this->render('product/index.html.twig', [
                    'controller_name'=>'ProductController',
                    'pagination'=>$pagination,
                    'formorder'=>$form->createView(),
                    'msgOk'=>$msgOk,
                    'msgError'=>$msgError
                ]);
            }
        }
        else
            {
            if ($order->getQuantityProductOrder() <= $prod->getStockProduct()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($order);
                $entityManager->flush();
                $msgOk='Article(s) ajouté(s) au panier.';
                return $this->render('product/index.html.twig', [
                    'controller_name'=>'ProductController',
                    'pagination'=>$pagination,
                    'formorder'=>$form->createView(),
                    'msgOk'=>$msgOk,
                    'msgError'=>$msgError
                ]);
            }
            else
            {
                $msgError='Quantité supérieur au stock, réessayer.';
                return $this->render('product/index.html.twig', [
                    'controller_name'=>'ProductController',
                    'pagination'=>$pagination,
                    'formorder'=>$form->createView(),
                    'msgOk'=>$msgOk,
                    'msgError'=>$msgError
                ]);

            }
        }


    }
    /**
     * @Route("/admin/new", name="product_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('list');
        }

        return $this->render('admin/product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}", name="product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('admin/product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/admin/product/{id}/edit", name="product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('admin/product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}", name="product_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_index');
    }
}
