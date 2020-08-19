<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request)
    {
        $API_key    = 'AIzaSyAyirpGBgsbAL96jEssw3zqn15Te7e6ESE'; // Remplacez par votre clé API
        $channelID  = 'UChaonIpYNG1TkPVUtzWRjjQ';  // Remplacez par votre identifiant Youtube
        $maxResults = 9;

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

        $decoded= json_decode(json_encode($data), true);

        dump($decoded['items']);

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
            'decoded'=>$decoded['items']
        ]);
    }
}
