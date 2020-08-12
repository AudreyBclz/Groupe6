<?php

namespace App\Controller;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminContactController extends AbstractController
{
    /**
     * @Route("/admin/contact", name="admin_contact")
     */
    public function index()
    {
        $msg=$this->getDoctrine()->getRepository(Contact::class)->findAll();
        return $this->render('admin_contact/index.html.twig', [
            'controller_name' => 'AdminContactController',
            'messages'=>$msg
        ]);
    }
}
