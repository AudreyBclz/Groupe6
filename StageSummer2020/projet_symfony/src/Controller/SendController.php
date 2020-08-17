<?php

namespace App\Controller;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SendController extends AbstractController
{
    /**
     * @Route("/admin/send", name="send")
     */
    public function index()
    {
        $msgNonlu=$this->getDoctrine()->getRepository(Contact::class)->findBy(['isRead'=>0,'isDeleted'=>0]);
        $msg=$this->getDoctrine()->getRepository(Contact::class)->findSend(1,0);
        return $this->render('send/index.html.twig', [
            'controller_name' => 'SendController',
            'msgNonLu'=>$msgNonlu,
            'messages'=>$msg
        ]);
    }

    /**
     * @Route("/admin/delDef/{id}", name="del_def")
     */
    public function delDef (Contact $contact)
    {
        $em=$this->getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush();
        $msgNonlu=$this->getDoctrine()->getRepository(Contact::class)->findBy(['isRead'=>0,'isDeleted'=>0]);
        $msg=$this->getDoctrine()->getRepository(Contact::class)->findSend(1,0);
        $alert='Message supprimé définitivement';
        return $this->render('send/index.html.twig', [
            'controller_name' => 'SendController',
            'msgNonLu'=>$msgNonlu,
            'messages'=>$msg,
            'alert'=>$alert
        ]);
    }
}
