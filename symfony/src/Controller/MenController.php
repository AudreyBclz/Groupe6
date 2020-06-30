<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MenController extends AbstractController
{
    /**
     * @Route("/men", name="men")
     */
    public function index()
    {
        return $this->render('men/index.html.twig', [
            'controller_name' => 'MenController',
        ]);
    }
}
