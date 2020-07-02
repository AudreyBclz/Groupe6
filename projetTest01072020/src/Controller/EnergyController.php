<?php

namespace App\Controller;

use App\Entity\Energy;
use App\Form\EnergyType;
use App\Repository\EnergyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/energy")
 */
class EnergyController extends AbstractController
{
    /**
     * @Route("/", name="energy_index", methods={"GET"})
     */
    public function index(EnergyRepository $energyRepository): Response
    {
        return $this->render('admin/energy/index.html.twig', [
            'energies' => $energyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/new", name="energy_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $energy = new Energy();
        $form = $this->createForm(EnergyType::class, $energy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($energy);
            $entityManager->flush();

            return $this->redirectToRoute('energy_index');
        }

        return $this->render('admin/energy/new.html.twig', [
            'energy' => $energy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}", name="energy_show", methods={"GET"})
     */
    public function show(Energy $energy): Response
    {
        return $this->render('admin/energy/show.html.twig', [
            'energy' => $energy,
        ]);
    }

    /**
     * @Route("/admin/{id}/edit", name="energy_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Energy $energy): Response
    {
        $form = $this->createForm(EnergyType::class, $energy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('energy_index');
        }

        return $this->render('admin/energy/edit.html.twig', [
            'energy' => $energy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}", name="energy_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Energy $energy): Response
    {
        if ($this->isCsrfTokenValid('delete'.$energy->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($energy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('energy_index');
    }
}
