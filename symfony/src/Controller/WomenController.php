<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class WomenController extends AbstractController
{
    /**
     * @Route("/women", name="women")
     */
    public function index()
    {
        return $this->render('women/index.html.twig', [
            'controller_name' => 'WomenController',
        ]);
    }
}
