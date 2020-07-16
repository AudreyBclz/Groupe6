<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\LivAddress;
use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RecapController extends AbstractController
{
    /**
     * @Route("/profile/recap/order", name="recap")
     */
    public function index()
    {
        $user=$this->getUser();
        $id=$user->getId();
        $address=$this->getDoctrine()->getRepository(Address::class)->address($id);
        $livaddress=$this->getDoctrine()->getRepository(LivAddress::class)->livaddress($id);
        $order=$this->getDoctrine()->getRepository(Order::class)->findBy(['user'=>$user,'statusOrder'=>NULL]);
        return $this->render('recap/index.html.twig', [
            'controller_name' => 'RecapController',
            'address'=>$address,
            'livAddress'=>$livaddress,
            'order'=>$order
        ]);
    }
}
