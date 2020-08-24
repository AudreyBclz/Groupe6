<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Form\SearchType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminContactController extends AbstractController
{
    /**
     * @Route("/admin/contact", name="admin_contact")
     */
    public function index(Request $request,PaginatorInterface $paginator)
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

                $pagination = $paginator->paginate(
                    $msg, /* query NOT result */
                    $request->query->getInt('page', 1), /*page number*/
                    12 /*limit per page*/);

                return $this->render('result_search/index.html.twig',array(
                    'controller_name'=>'ResultSearchController',
                    'messages'=>$pagination,
                    'msgNonLu'=>$msgNonlu,
                    'form'=>$formsearch->createView(),
                    'form2'=>$formsearch->createView()
                ));

            }
            else
            {
                $msgNonlu=$this->getDoctrine()->getRepository(Contact::class)->findBy(['isRead'=>0,'isDeleted'=>0]);
                $msg=$this->getDoctrine()->getRepository(Contact::class)->findSend(0,0);

                $pagination = $paginator->paginate(
                    $msg, /* query NOT result */
                    $request->query->getInt('page', 1), /*page number*/
                    12 /*limit per page*/);

                return $this->render('admin_contact/index.html.twig', [
                    'controller_name' => 'AdminContactController',
                    'messages'=>$pagination,
                    'msgNonLu'=>$msgNonlu,
                    'form'=>$formsearch->createView(),
                    'form2'=>$formsearch->createView()
                ]);
            }

        }

    }

    /**
     * @Route("/admin/read/{id}", name="admin_read")
     */
    public function read (Contact $contact)
    {
        $contact->setIsRead(true);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('admin_contact');
    }

    /**
     * @Route("/admin/notread/{id}", name="admin_notread")
     */
    public function notread (Contact $contact)
    {
        $contact->setIsRead(false);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('admin_contact');
    }

    /**
     * @Route("/admin/delete/{id}", name="admin_delete")
     */
    public function delete (Contact $contact,Request $request,PaginatorInterface $paginator)
    {
        $formsearch=$this->createForm(SearchType::class);
        $formsearch->handleRequest($request);


        $contact->setIsDeleted(true);
        $this->getDoctrine()->getManager()->flush();
        $alert="Message supprimé";
        $msgNonlu=$this->getDoctrine()->getRepository(Contact::class)->findBy(['isRead'=>0,'isDeleted'=>0]);
        $msg=$this->getDoctrine()->getRepository(Contact::class)->findSend(0,0);

        $pagination = $paginator->paginate(
            $msg, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            12 /*limit per page*/);


        return $this->render('admin_contact/index.html.twig',[
            'controller_name' => 'AdminContactController',
            'messages'=>$pagination,
            'msgNonLu'=>$msgNonlu,
            'alert'=>$alert,
            'form'=>$formsearch->createView(),
            'form2'=>$formsearch->createView()
        ]);
    }

    /**
     * @Route("/admin/deleteRead/{id}", name="admin_deleteRead")
     */
    public function deleteRead (Contact $contact,Request $request,PaginatorInterface $paginator)
    {
        $formsearch=$this->createForm(SearchType::class);
        $formsearch->handleRequest($request);


        $contact->setIsDeleted(true);
        $contact->setIsRead(true);
        $this->getDoctrine()->getManager()->flush();
        $alert="Message supprimé";
        $msgNonlu=$this->getDoctrine()->getRepository(Contact::class)->findBy(['isRead'=>0,'isDeleted'=>0]);
        $msg=$this->getDoctrine()->getRepository(Contact::class)->findSend(0,0);

        $pagination = $paginator->paginate(
            $msg, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            12 /*limit per page*/);


        return $this->render('admin_contact/index.html.twig',[
            'controller_name' => 'AdminContactController',
            'messages'=>$pagination,
            'msgNonLu'=>$msgNonlu,
            'alert'=>$alert,
            'form'=>$formsearch->createView(),
            'form2'=>$formsearch->createView()
        ]);
    }

}
