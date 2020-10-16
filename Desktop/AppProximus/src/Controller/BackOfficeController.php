<?php

namespace App\Controller;

use App\Entity\BackOffice;
use App\Form\BackOfficeType;
use App\Repository\BackOfficeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/office")
 */
class BackOfficeController extends AbstractController
{
    /**
     * @Route("/", name="back_office_index", methods={"GET"})
     */
    public function index(BackOfficeRepository $backOfficeRepository): Response
    {
        return $this->render('back_office/index.html.twig', [
            'back_offices' => $backOfficeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="back_office_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $backOffice = new BackOffice();
        $form = $this->createForm(BackOfficeType::class, $backOffice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($backOffice);
            $entityManager->flush();

            return $this->redirectToRoute('back_office_index');
        }

        return $this->render('back_office/new.html.twig', [
            'back_office' => $backOffice,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="back_office_show", methods={"GET"})
     */
    public function show(BackOffice $backOffice): Response
    {
        return $this->render('back_office/show.html.twig', [
            'back_office' => $backOffice,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="back_office_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BackOffice $backOffice): Response
    {
        $form = $this->createForm(BackOfficeType::class, $backOffice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_office_index');
        }

        return $this->render('back_office/edit.html.twig', [
            'back_office' => $backOffice,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="back_office_delete", methods={"DELETE"})
     */
    public function delete(Request $request, BackOffice $backOffice): Response
    {
        if ($this->isCsrfTokenValid('delete'.$backOffice->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($backOffice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_office_index');
    }
}
