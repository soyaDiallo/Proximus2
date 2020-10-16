<?php

namespace App\Controller;

use App\Entity\Superviseur;
use App\Form\SuperviseurType;
use App\Repository\SuperviseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/superviseur")
 */
class SuperviseurController extends AbstractController
{
    /**
     * @Route("/", name="superviseur_index", methods={"GET"})
     */
    public function index(SuperviseurRepository $superviseurRepository): Response
    {
        return $this->render('superviseur/index.html.twig', [
            'superviseurs' => $superviseurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="superviseur_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $superviseur = new Superviseur();
        $form = $this->createForm(SuperviseurType::class, $superviseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($superviseur);
            $entityManager->flush();

            return $this->redirectToRoute('superviseur_index');
        }

        return $this->render('superviseur/new.html.twig', [
            'superviseur' => $superviseur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="superviseur_show", methods={"GET"})
     */
    public function show(Superviseur $superviseur): Response
    {
        return $this->render('superviseur/show.html.twig', [
            'superviseur' => $superviseur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="superviseur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Superviseur $superviseur): Response
    {
        $form = $this->createForm(SuperviseurType::class, $superviseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('superviseur_index');
        }

        return $this->render('superviseur/edit.html.twig', [
            'superviseur' => $superviseur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="superviseur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Superviseur $superviseur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$superviseur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($superviseur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('superviseur_index');
    }
}
