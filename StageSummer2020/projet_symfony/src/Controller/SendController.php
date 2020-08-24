<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\SearchType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SendController extends AbstractController
{
    /**
     * @Route("/admin/send", name="send")
     */
    public function index(Request $request,PaginatorInterface $paginator)
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
        else {

            $msgNonlu = $this->getDoctrine()->getRepository(Contact::class)->findBy(['isRead' => 0, 'isDeleted' => 0]);
            $msg = $this->getDoctrine()->getRepository(Contact::class)->findSend(1, 0);

            $pagination = $paginator->paginate(
                $msg, /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                12 /*limit per page*/);

            return $this->render('send/index.html.twig', [
                'controller_name' => 'SendController',
                'msgNonLu' => $msgNonlu,
                'messages' => $pagination,
                'form' => $formsearch->createView(),
                'form2' => $formsearch->createView()
            ]);
        }
    }

    /**
     * @Route("/admin/delDef/{id}", name="del_def")
     */
    public function delDef (Contact $contact,Request $request,PaginatorInterface $paginator)
    {
        $formsearch=$this->createForm(SearchType::class);
        $formsearch->handleRequest($request);

        $em=$this->getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush();
        $msgNonlu=$this->getDoctrine()->getRepository(Contact::class)->findBy(['isRead'=>0,'isDeleted'=>0]);
        $msg=$this->getDoctrine()->getRepository(Contact::class)->findSend(1,0);

        $pagination = $paginator->paginate(
            $msg, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            12 /*limit per page*/);

        $alert='Message supprimé définitivement';
        return $this->render('send/index.html.twig', [
            'controller_name' => 'SendController',
            'msgNonLu'=>$msgNonlu,
            'messages'=>$pagination,
            'alert'=>$alert,
            'form'=>$formsearch->createView(),
            'form2'=>$formsearch->createView()
        ]);
    }
}
