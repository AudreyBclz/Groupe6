<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request)
    {
        $message="";
        $contact=new Contact();
        $form=$this->createForm(ContactType::class,$contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager= $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();
            $message='Merci! Votre message a été envoyé.';
        }
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'form'=>$form->createView(),
            'message'=>$message
        ]);
    }
}
