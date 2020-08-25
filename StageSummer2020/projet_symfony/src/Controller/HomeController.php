<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request,CacheInterface $cache)
    {
        $decoded=$cache->get('data-ytb',function (ItemInterface $item){
            $item->expiresAfter(86400);

            $API_key    = 'AIzaSyDYSmQoy0AjwdT_VnWK2pbXH3DYz_kslUg';
            $channelID  = 'UChaonIpYNG1TkPVUtzWRjjQ';
            $maxResults = 12;

// Faire un Appel API pour récuperer la liste des vidéos en format Json
            $myQuery = "https://www.googleapis.com/youtube/v3/search?key=$API_key&channelId=$channelID&part=snippet,id&order=date&maxResults=$maxResults";
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $myQuery);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_VERBOSE, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);

            curl_close($ch);

            $data = json_decode($response);

            return $decoded= json_decode(json_encode($data), true);


        });

        $client_id=7080023405;
        $redirect_uri='https://localhost:8001';
        $access_token='IGQVJVdDNxZADJrMUFucTNiaXJfUkFkVFBpQzR1Vy03dDBKRkVmZAnNnWE9VLXNpWkNlZAGJBUURMQmlXalQxQ282dndlZAHAzZAE05T1lFVmxYLUc5akY4YXg3R3N1RVRUdDhzdW1xa3YzZATY1S2RtLW1GOAZDZD';

        $query="https://graph.instagram.com/".$client_id.'/media';


        $message="";
        $contact=new Contact();
        $form=$this->createForm(ContactType::class,$contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager= $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();
            $message='Merci! Votre message a été envoyé.';
        }
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'form'=>$form->createView(),
            'message'=>$message,
            'decoded'=>$decoded['items'],
        ]);
    }
}
