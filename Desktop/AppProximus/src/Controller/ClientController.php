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
use App\Form\ClientNewType;
use App\Form\EditRegistrationFormType;
use App\Form\OffreClientType;
use App\Form\RegistrationFormType;
use App\Repository\ClientRepository;
use App\Security\UsersAuthenticathorAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

/**
 * @Route("/clients")
 * @Security("is_granted('ROLE_ADMINISTRATEUR')")
 */
class ClientController extends AbstractController
{
    /**
     * @Route("/", name="client_index", methods={"GET"})
     */
    public function index(ClientRepository $clientRepository): Response
    {
        return $this->render('client/index.html.twig', [
            'clients' => $clientRepository->findAll(),
        ]);
    }

    /**
     * @Route("/modifier/{id}", name="client_edit", methods={"GET", "POST"})
     */
    public function edit(ClientRepository $clientRepository, int $id = 0, Request $request): Response
    {
        $client = $clientRepository->find($id);
        $form = $this->createForm(OffreClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('client_index');
        }

        return $this->render('client/edit.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/nouveau", name="client_new")
     */
    public function new(Request $request, ClientRepository $clientRepository): Response
    {
        $client = new Client();
        $form = $this->createForm(OffreClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('client_index');
        }

        return $this->render('client/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
