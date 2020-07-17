<?php

namespace App\Controller;

use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CommandController extends AbstractController
{
    /**
     * @Route("/profile/command", name="command")
     */
    public function index()
    {
        $user=$this->getUser();
        $panier=$this->getDoctrine()->getRepository(Order::class)->findBy(['user'=>$user,'statusOrder'=>NULL]);
        foreach ($panier as $pan)
        {
            $date= new \DateTime('now');
            $dateOk=$date->format('d-m-Y H:i:s');
            $status='Payé le '.$dateOk ;
            $pan->setStatusOrder($status);
            $this->getDoctrine()->getManager()->flush();
        }
        $msg='Commande bien enregistrée';
        return $this->render('command/index.html.twig', [
            'controller_name' => 'CommandController',
            'msg'=>$msg
        ]);
    }
}
