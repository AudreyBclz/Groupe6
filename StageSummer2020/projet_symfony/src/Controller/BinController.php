<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BinController extends AbstractController
{
    /**
     * @Route("/admin/bin", name="bin")
     */
    public function index(Request $request)
    {
        if (is_null($this->getUser()))
        {
            return $this->redirectToRoute('home');
        }
        else
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
                $msg = $this->getDoctrine()->getRepository(Contact::class)->findSend(0, 1);
                return $this->render('bin/index.html.twig', [
                    'controller_name' => 'AdminContactController',
                    'messages' => $msg,
                    'msgNonLu' => $msgNonlu,
                    'form'=>$formsearch->createView(),
                    'form2'=>$formsearch->createView()
                ]);
            }
        }

    }

    /**
     * @Route("/admin/binread/{id}", name="admin_binread")
     */
    public function binread (Contact $contact, Request $request)
    {
        $formsearch=$this->createForm(SearchType::class);
        $formsearch->handleRequest($request);

        $msgNonlu=$this->getDoctrine()->getRepository(Contact::class)->findBy(['isRead'=>0,'isDeleted'=>0]);
        $msg=$this->getDoctrine()->getRepository(Contact::class)->findSend(0,0);
        $contact->setIsRead(true);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('bin');

    }

    /**
     * @Route("/admin/binnotread/{id}", name="admin_binnotread")
     */
    public function binnotread (Contact $contact)
    {
        $msgNonlu=$this->getDoctrine()->getRepository(Contact::class)->findBy(['isRead'=>0,'isDeleted'=>0]);
        $msg=$this->getDoctrine()->getRepository(Contact::class)->findSend(0,0);
        $contact->setIsRead(false);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('bin');
    }

    /**
     * @Route("/admin/restore/{id}", name="admin_restore")
     */
    public function restore(Contact $contact)
    {
        $contact->setIsDeleted(false);
        $this->getDoctrine()->getManager()->flush();
        $alert="Le message a bien été restauré.";
        $msgNonlu=$this->getDoctrine()->getRepository(Contact::class)->findBy(['isRead'=>0,'isDeleted'=>0]);
        $msg=$this->getDoctrine()->getRepository(Contact::class)->findSend(0,0);
        return $this->render('admin_contact/index.html.twig',[
            'controller_name' => 'BinController',
            'messages'=>$msg,
            'msgNonLu'=>$msgNonlu,
            'alert'=>$alert
        ]);
    }

    /**
     * @Route("/admin/delBin/{id}", name="del_bin")
     */
    public function delbin (Contact $contact)
    {
        $em=$this->getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush();
        $msgNonlu=$this->getDoctrine()->getRepository(Contact::class)->findBy(['isRead'=>0,'isDeleted'=>0]);
        $msg=$this->getDoctrine()->getRepository(Contact::class)->findSend(0,1);
        $alert='Message supprimé définitivement';
        return $this->render('bin/index.html.twig', [
            'controller_name' => 'BinController',
            'msgNonLu'=>$msgNonlu,
            'messages'=>$msg,
            'alert'=>$alert
        ]);
    }

    /**
     * @Route("/admin/readBin/{id}", name="admin_readBin")
     */
    public function read (Contact $contact)
    {
        $msgNonlu=$this->getDoctrine()->getRepository(Contact::class)->findBy(['isRead'=>0,'isDeleted'=>0]);
        $msg=$this->getDoctrine()->getRepository(Contact::class)->findSend(0,0);
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
        $msgNonlu=$this->getDoctrine()->getRepository(Contact::class)->findBy(['isRead'=>0,'isDeleted'=>0]);
        $msg=$this->getDoctrine()->getRepository(Contact::class)->findSend(0,0);
        $contact->setIsRead(false);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('admin_contact');

        return $this->render('admin_contact/index.html.twig',[
            'controller_name' => 'AdminContactController',
            'messages'=>$msg,
            'msgNonLu'=>$msgNonlu
        ]);
    }

    /**
     * @Route("/admin/delAll", name="admin_delAll")
     */
    public function delAll()
    {
        $msgDel=$this->getDoctrine()->getRepository(Contact::class)->findSend(0,1);
        foreach($msgDel as $msg)
        {
            $this->getDoctrine()->getRepository(Contact::class)->delBin($msg->getId());
        }
        $msgNonlu=$this->getDoctrine()->getRepository(Contact::class)->findBy(['isRead'=>0,'isDeleted'=>0]);
        $msgs=$this->getDoctrine()->getRepository(Contact::class)->findSend(0,0);
        $alert='La corbeille a été vidée.';

        return $this->render('admin_contact/index.html.twig',[
            'controller_name'=>'AdminContactController',
            'messages'=>$msgs,
            'msgNonLu'=>$msgNonlu,
            'alert'=>$alert
        ]);
    }
}

