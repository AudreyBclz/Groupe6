<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request,\Swift_Mailer $mailer):Response
    {
        $contact = new Contact();

        $form=$this->createForm(ContactType::class,$contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $sujet = $contact->getSujet();
            $mes = $contact->getContenuMessage();
            $from = $contact->getPrenomContact().' '.$contact->getNomContact();
            $email = $contact->getEmail();

            $textBody = "<h3>Message envoyé par ".$from."</h3><p>Le sujet : ".$sujet."</p><p>Votre message</p><p>".$mes."</p><p>Votre adresse e-mail : </p>".$email;

            $message = (new \Swift_Message($sujet))
                ->setFrom($email)
                ->setTo('alohaha638@gmail.com')
                ->setBody($textBody, 'text/html', 'utf-8');

            $mailer->send($message);

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($contact);

            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'form'=>$form->createView()
        ]);
    }
}
