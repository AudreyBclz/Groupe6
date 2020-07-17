<?php

namespace App\Controller;

use App\Form\PayType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PayController extends AbstractController
{
    /**
     * @Route("/profile/pay/payment", name="pay")
     */
    public function index(Request $request)
    {
        $form=$this->createForm(PayType::class)
            ->handleRequest($request);

        return $this->render('pay/index.html.twig', [
            'controller_name' => 'PayController',
            'form'=>$form->createView()
        ]);
    }
}
