<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\Order1Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    /**
     * @Route("/profile/panier", name="panier")
     */
    public function index()
    {
        $user=$this->getUser();
        $panier=$this->getDoctrine()->getRepository(Order::class)->findBy(['user'=>$user,'statusOrder'=>NULL]);
        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
            'panier'=>$panier
        ]);
    }

    /**
     * @Route("/profile/{id}", name="panier_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Order $order): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($order);
            $entityManager->flush();
        }
        return $this->redirectToRoute('panier');
    }

    /**
     * @Route("/profile/{id}", name="panier_show", methods={"GET"})
     */
    public function show(Order $order): Response
    {
        return $this->render('order/show.html.twig', [
            'order' => $order,
        ]);
    }
}
