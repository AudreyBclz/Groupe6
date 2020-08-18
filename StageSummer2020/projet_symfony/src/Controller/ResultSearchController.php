<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ResultSearchController extends AbstractController
{
    /**
     * @Route("/result/search", name="result_search")
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
    }
}
