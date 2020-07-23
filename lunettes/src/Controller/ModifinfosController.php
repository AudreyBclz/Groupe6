<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\User;
use App\Form\AddressType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ModifinfosController extends AbstractController
{
    /**
     * @Route("/profile/modifinfos", name="modifinfos")
     */
    public function index(Request $request,UserPasswordEncoderInterface $passwordEncoder)
    {
        $user=new User();
        $me=$this->getDoctrine()->getRepository(User::class)->findOneBy(['email'=>$this->getUser()->getUsername()]);
        $formU=$this->createForm(UserType::class,$user);
        $formU->handleRequest($request);

        $ad=$me->getAddress();


    if($formU->isSubmitted() && $formU->isValid())
    {
        $f_add=$user->getAddress()->getFirstAddress();
        $s_add=$user->getAddress()->getSecondAddress();
        $zip=$user->getAddress()->getZipcodeAddress();
        $town=$user->getAddress()->getTownAddress();
        $country=$user->getAddress()->getCountryAddress();
        $checkAd=$this->getDoctrine()->getRepository(Address::class)->findOneBy(['firstAddress'=>$f_add,'secondAddress'=>$s_add,'zipcodeAddress'=>$zip,'townAddress'=>$town,'countryAddress'=>$country]);

        $me->setCivUser($user->getCivUser());
        $me->setFirstNameUser($user->getFirstNameUser());
        $me->setLastNameUser($user->getLastNameUser());

        $me->setPassword(
            $passwordEncoder->encodePassword(
                $user,
                $formU->get('password')->getData()
            )
        );
        $me->setTelUser($user->getTelUser());
        $me->setAddress($checkAd);

        if(!is_null($checkAd))
        {
            $this->getDoctrine()->getManager()->flush();
        }
        else
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user->getAddress());
            $entityManager->flush();
            $this->getUser()->setAddress($user->getAddress());
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->redirectToRoute('infos');

    }



        return $this->render('modifinfos/index.html.twig', [
            'controller_name' => 'ModifinfosController',
            'form'=>$formU->createView(),
            'info'=>$me,
            'address'=>$ad

        ]);
    }
}
