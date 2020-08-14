<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ReponseController extends AbstractController
{
    /**
     * @Route("/admin/reponse/{id}", name="reponse")
     */
    public function index(Contact $contact, Request $request, \Swift_Mailer $mailer)
    {
        $contact2=new Contact();
        $msgNonlu=$this->getDoctrine()->getRepository(Contact::class)->findBy(['isRead'=>0]);
        $msg=$this->getDoctrine()->getRepository(Contact::class)->findSend(0);
        $contact2->setIsRead(1);
        $contact2->setIsDeleted(0);
        $contact2->setFullName('Areliann');
        date_default_timezone_set('Europe/Paris');
        $contact2->setDate(new \DateTime(NULL));
        $contact2->setContent('');
        $contact2->setEmail('alohaha638@gmail.com');
        $contact2->setSubject('Re : '.$contact->getSubject());
        $form=$this->createForm(ContactType::class,$contact2);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid())
        {
            $subject=$contact2->getSubject();
            $content=$contact2->getContent();
            $from=$contact2->getFullName();
            $addEmail=$contact->getEmail();

            $textBody='<h3>'.$from.' </h3><h5> Le sujet :'.$subject.'</h6><p>Le message </p><p>'.$content.' </p>';

            $mes = (new \Swift_Message($subject))
                ->setFrom($contact2->getEmail())
                ->setTo($addEmail)
                ->setBody($textBody,'text/html','utf-8');

            $mailer->send($mes);

            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($contact2);
            $entityManager->flush();
            return $this->redirectToRoute('admin_contact');
        }
        return $this->render('reponse/index.html.twig', [
            'controller_name' => 'ReponseController',
            'form'=>$form->createView(),
            'msgNonLu'=>$msgNonlu,
            'messages'=>$msg
        ]);
    }
}
