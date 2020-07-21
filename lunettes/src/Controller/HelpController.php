<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelpController extends AbstractController
{
    /**
     * @Route("/help", name="help")
     */
    public function index(Request $request,\Swift_Mailer $mailer):Response
    {
        $message="";
        $contact=new Contact();
        $form=$this->createForm(ContactType::class,$contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isSubmitted())
        {
            $subject=$contact->getSubject();
            $content=$contact->getContent();
            $from=$contact->getFullName();
            $addEmail=$contact->getEmailContact();

            $textBody='<h3>'.$from.' </h3><h5> The Subject :'.$subject.' </h5><h6>The contact mail : '.$addEmail.' </h6><p>The message </p><p>'.$content.' </p>';

            $mes = (new \Swift_Message($subject))
                ->setFrom($addEmail)
                ->setTo('alohaha638@gmail.com')
                ->setBody($textBody,'text/html','utf-8');

            $mailer->send($mes);

            $entityManager= $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();
            $message='Thank you! Your message has been sent.';
        }

        return $this->render('help/index.html.twig', [
            'controller_name' => 'HelpController',
            'form'=>$form->createView(),
            'message'=>$message
        ]);
    }
}
