<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\LivAddress;
use App\Entity\User;
use App\Form\LivAddressType;
use App\Repository\LivAddressRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/liv/address")
 */
class LivAddressController extends AbstractController
{
    /**
     * @Route("/admin/", name="liv_address_index", methods={"GET"})
     */
    public function index(LivAddressRepository $livAddressRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $liv_list=$livAddressRepository->findAll();

        $liv_addresses= $paginator->paginate(
            $liv_list, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('admin/liv_address/index.html.twig', [
            'liv_addresses' => $liv_addresses,
        ]);
    }

    /**
     * @Route("/profile/new", name="liv_address_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $livAddress = new LivAddress();
        $form = $this->createForm(LivAddressType::class, $livAddress);
        $form->handleRequest($request);

        $fname_address=$livAddress->getFirstNameLiv();
        $lname_address=$livAddress->getLastNameLiv();
        $f_address=$livAddress->getFirstAdLiv();
        $s_address=$livAddress->getSecondAdLiv();
        $zip=$livAddress->getZipcodeLiv();
        $town=$livAddress->getTownLiv();
        $country=$livAddress->getCountryLiv();

        $address=$this->getDoctrine()->getRepository(LivAddress::class)->findOneBy(['firstNameLiv'=>$fname_address,'lastNameLiv'=>$lname_address,
            'firstAdLiv'=>$f_address,'secondAdLiv'=>$s_address,'zipcodeLiv'=>$zip,'townLiv'=>$town,'countryLiv'=>$country]);
        if ($address)
        {
            $user=$this->getDoctrine()->getRepository(User::class)->findOneBy(['email'=>$this->getUser()->getUsername()]);
            $user->setLivAddress($address);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('recap');
        }
        elseif ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($livAddress);
            $entityManager->flush();
            $this->getUser()->setLivAddress($livAddress);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('recap');
        }

        return $this->render('liv_address/new.html.twig', [
            'liv_address' => $livAddress,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}", name="liv_address_show", methods={"GET"})
     */
    public function show(LivAddress $livAddress): Response
    {
        return $this->render('admin/liv_address/show.html.twig', [
            'liv_address' => $livAddress,
        ]);
    }

    /**
     * @Route("/admin/{id}/edit", name="liv_address_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, LivAddress $livAddress): Response
    {
        $form = $this->createForm(LivAddressType::class, $livAddress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('liv_address_index');
        }

        return $this->render('admin/liv_address/edit.html.twig', [
            'liv_address' => $livAddress,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}", name="liv_address_delete", methods={"DELETE"})
     */
    public function delete(Request $request, LivAddress $livAddress): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livAddress->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($livAddress);
            $entityManager->flush();
        }

        return $this->redirectToRoute('liv_address_index');
    }
}
