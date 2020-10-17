<?php

namespace App\Controller;

use App\Entity\Agent;
use App\Entity\Offre;
use App\Form\AgentType;
use App\Form\CreationOffreType;
use App\Form\OffreType;
use App\Repository\AgentRepository;
use App\Repository\ClientRepository;
use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/offres")
 * @Security("is_granted('ROLE_USER')")
 */
class OfferController extends AbstractController
{
    /**
     * @Route("/", name="offer_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('offer/index.html.twig');
    }

    /**
     * @Route("/nouvelle/{id}", name="offer_new", methods={"GET", "POST"})
     */
    public function new(ClientRepository $clientRepository, Request $request, int $id = 0): Response
    {
        $offre = new Offre();
        $offre->setClient($clientRepository->find($id));
        $form = $this->createForm(CreationOffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($request);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offre);
            $entityManager->flush();

            return $this->redirectToRoute('offer_index');
        }

        return $this->render('offer/new.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/nouvelle/{id}", name="offer_new_sale", methods={"GET", "POST"})
     */
    public function newSale(ClientRepository $clientRepository, Request $request, int $id = 0): Response
    {
        /*
        $offre = new Offre();
        $offre->setClient($clientRepository->find($id));
        $form = $this->createForm(CreationOffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($request);
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offre);
            $entityManager->flush();

            return $this->redirectToRoute('offer_index');
        }
        */

        return $this->render('offer/new.html.twig', [
            //  'offre' => $offre,
            //  'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/modifier/{id}", name="offer_edit", methods={"GET"})
     */
    public function edit(Request $request, int $id = 0): Response
    {
        /*
        $offre = new Offre();
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offre);
            $entityManager->flush();

            return $this->redirectToRoute('offer_index');
        }
        */

        return $this->render('offer/edit.html.twig', [
            //  'offre' => $offre,
            //  'form' => $form->createView(),
        ]);
    }
}
