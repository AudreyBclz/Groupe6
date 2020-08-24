<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Form\SearchType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ReponseController extends AbstractController
{
    /**
     * @Route("/admin/reponse/{id}", name="reponse")
     */
    public function index(Contact $contact, Request $request, \Swift_Mailer $mailer,PaginatorInterface $paginator)
    {
        $formsearch=$this->createForm(SearchType::class);
        $formsearch->handleRequest($request);

        $contact->setIsRead(true);
        $this->getDoctrine()->getManager()->flush();
        $msgNonlu=$this->getDoctrine()->getRepository(Contact::class)->findBy(['isRead'=>0,'isDeleted'=>0]);
        $msg=$this->getDoctrine()->getRepository(Contact::class)->findSend(0,0);
        $pagination = $paginator->paginate(
            $msg, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            12 /*limit per page*/);
        $alert='';
        $contact2=new Contact();
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

            $mes = (new \Swift_Message($subject));
            $mes->setFrom($contact2->getEmail())
                ->setTo($addEmail);
             $mes->setBody('<html>
                                    <head>
                                        <meta charset="UTF-8">
                                    </head>
                                    <body style="background-color: blue;">
                                        <div style="width: 700px; height: 233px; margin: auto;">
                                        <img src="https://pbs.twimg.com/profile_banners/2409603655/1596461503/1500x500" alt="Bannière Areliann">
                                        </div>
                                        <h1 style="text-align: center;">Réponse à votre message</h1><h2> Le sujet :'.$subject.'</h2><h2>Le message </h2><p>'.$content.' </p>
                                    </body>
                                 </html>','text/html','utf-8');


            $mailer->send($mes);

            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($contact2);
            $entityManager->flush();
            $alert="Le message a bien été envoyé.";
            return $this->render('admin_contact/index.html.twig', [
                'controller_name' => 'ReponseController',
                'msgNonLu'=>$msgNonlu,
                'messages'=>$pagination,
                'alert'=>$alert,
                'form'=>$formsearch->createView(),
                'form2'=>$formsearch->createView()
            ]);

        }
        else
        {
            return $this->render('reponse/index.html.twig', [
                'controller_name' => 'ReponseController',
                'formcontact'=>$form->createView(),
                'msgNonLu'=>$msgNonlu,
                'messages'=>$pagination,
                'form'=>$formsearch->createView(),
                'form2'=>$formsearch->createView()
            ]);
        }

    }
}
