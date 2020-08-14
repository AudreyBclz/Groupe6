<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminContactController extends AbstractController
{
    /**
     * @Route("/admin/contact", name="admin_contact")
     */
    public function index()
    {
        if (is_null($this->getUser()))
        {
            return $this->redirectToRoute('home');
        }
        else
        {
            $msgNonlu=$this->getDoctrine()->getRepository(Contact::class)->findBy(['isRead'=>0]);
            $msg=$this->getDoctrine()->getRepository(Contact::class)->findSend(0);
            return $this->render('admin_contact/index.html.twig', [
                'controller_name' => 'AdminContactController',
                'messages'=>$msg,
                'msgNonLu'=>$msgNonlu
            ]);
        }

    }

    /**
     * @Route("/admin/read/{id}", name="admin_read")
     */
    public function read (Contact $contact)
    {
        $msgNonlu=$this->getDoctrine()->getRepository(Contact::class)->findBy(['isRead'=>0]);
        $msg=$this->getDoctrine()->getRepository(Contact::class)->findSend(0);
            $contact->setIsRead(true);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('admin_contact');

            return $this->render('admin_contact/index.html.twig',[
                'controller_name' => 'AdminContactController',
                'messages'=>$msg,
                'msgNonLu'=>$msgNonlu
            ]);
    }

    /**
     * @Route("/admin/notread/{id}", name="admin_notread")
     */
    public function notread (Contact $contact)
    {
        $msgNonlu=$this->getDoctrine()->getRepository(Contact::class)->findBy(['isRead'=>0]);
        $msg=$this->getDoctrine()->getRepository(Contact::class)->findSend(0);
        $contact->setIsRead(false);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('admin_contact');

        return $this->render('admin_contact/index.html.twig',[
            'controller_name' => 'AdminContactController',
            'messages'=>$msg,
            'msgNonLu'=>$msgNonlu
        ]);
    }



}
