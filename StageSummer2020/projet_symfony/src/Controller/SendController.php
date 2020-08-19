<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SendController extends AbstractController
{
    /**
     * @Route("/admin/send", name="send")
     */
    public function index(Request $request)
    {
        $formsearch=$this->createForm(SearchType::class);
        $formsearch->handleRequest($request);


        if($formsearch->isSubmitted() && $formsearch->isValid())
        {
            $search=$request->get("search")['search'];
            $msgNonlu=$this->getDoctrine()->getRepository(Contact::class)->findBy(['isRead'=>0,'isDeleted'=>0]);
            $msg=$this->getDoctrine()->getRepository(Contact::class)->search($search);
            return $this->render('result_search/index.html.twig',array(
                'controller_name'=>'ResultSearchController',
                'messages'=>$msg,
                'msgNonLu'=>$msgNonlu,
                'form'=>$formsearch->createView(),
                'form2'=>$formsearch->createView()
            ));

        }
        else {

            $msgNonlu = $this->getDoctrine()->getRepository(Contact::class)->findBy(['isRead' => 0, 'isDeleted' => 0]);
            $msg = $this->getDoctrine()->getRepository(Contact::class)->findSend(1, 0);
            return $this->render('send/index.html.twig', [
                'controller_name' => 'SendController',
                'msgNonLu' => $msgNonlu,
                'messages' => $msg,
                'form' => $formsearch->createView(),
                'form2' => $formsearch->createView()
            ]);
        }
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
