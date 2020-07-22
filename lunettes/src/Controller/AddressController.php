<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/address")
 */
class AddressController extends AbstractController
{
    /**
     * @Route("/", name="address_index", methods={"GET"})
     */
    public function index(AddressRepository $addressRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $add_list=$addressRepository->findAll();

        $addresses= $paginator->paginate(
            $add_list, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('admin/address/index.html.twig', [
            'addresses' => $addresses,
        ]);
    }

    /**
     * @Route("/admin/new", name="address_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($address);
            $entityManager->flush();

            return $this->redirectToRoute('address_index');
        }

        return $this->render('admin/address/new.html.twig', [
            'address' => $address,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}", name="address_show", methods={"GET"})
     */
    public function show(Address $address): Response
    {
        return $this->render('admin/address/show.html.twig', [
            'address' => $address,
        ]);
    }

    /**
     * @Route("/admin/{id}/edit", name="address_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Address $address): Response
    {
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('address_index');
        }

        return $this->render('admin/address/edit.html.twig', [
            'address' => $address,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}", name="address_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Address $address): Response
    {
        if ($this->isCsrfTokenValid('delete'.$address->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($address);
            $entityManager->flush();
        }

        return $this->redirectToRoute('address_index');
    }
}
