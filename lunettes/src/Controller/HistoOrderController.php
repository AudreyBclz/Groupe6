<?php

namespace App\Controller;

use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HistoOrderController extends AbstractController
{
    /**
     * @Route("/Profile/histo/order", name="histo_order")
     */
    public function index()
    {
        $orders=$this->getDoctrine()->getRepository(Order::class)->findCommand($this->getUser());
        dump($orders);
        return $this->render('histo_order/index.html.twig', [
            'controller_name' => 'HistoOrderController',
            'orders'=>$orders
        ]);
    }
}
