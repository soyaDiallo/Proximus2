<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Entity\User;
use App\Entity\Agent;
use App\Entity\BackOffice;
use App\Entity\Superviseur;
use App\Entity\Administrateur;
use App\Entity\Client;
use App\Entity\Produit;
use App\Form\ClientNewType;
use App\Form\EditRegistrationFormType;
use App\Form\RegistrationFormType;
use App\Repository\ClientRepository;
use App\Repository\ProduitRepository;
use App\Security\UsersAuthenticathorAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

/**
 * @Route("/produits")
 * @Security("is_granted('ROLE_ADMINISTRATEUR')")
 */
class ProduitController extends AbstractController
{
    /**
     * @Route("/", name="produit_index", methods={"GET"})
     */
    public function index(ProduitRepository $produitRepository): Response
    {
        dd($produitRepository->findAll());

        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    /**
     * @Route("/modifier/{id}", name="produit_edit", methods={"GET", "POST"})
     */
    public function edit(ProduitRepository $produitRepository, int $id = 0, Request $request): Response
    {
        $produit = $produitRepository->find($id);
        $form = $this->createForm(ClientNewType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('produit_index');
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/nouveau", name="produit_new")
     */
    public function new(Request $request, ProduitRepository $produitRepository): Response
    {
        $produit = new Produit();
        $form = $this->createForm(EditRegistrationFormType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('produit_index');
        }

        return $this->render('produit/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
