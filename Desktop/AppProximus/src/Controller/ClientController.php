<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Entity\Client;
use App\Entity\Fournisseur;
use App\Form\FournisseurType;
use App\Form\OffreClientType;
use App\Repository\ClientRepository;
use App\Repository\FournisseurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/clients")
 * @Security("is_granted('ROLE_ADMINISTRATEUR')")
 */
class ClientController extends AbstractController
{
    /**
     * @Route("/", name="client_index", methods={"GET", "POST"})
     */
    public function index(ClientRepository $clientRepository, FournisseurRepository $fournisseurRepository, Request $request): Response
    {
        $fournisseur = new Fournisseur();
        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fournisseur);
            $entityManager->flush();

            return $this->redirectToRoute('client_index');
        }

        return $this->render('client/index.html.twig', [
            'clients' => $clientRepository->findAll(),
            'fournisseurs' => $fournisseurRepository->findAll(),
            'formFournisseur' => $form->createView(),
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

    /**
     * @Route("/import", name="import_client", methods={"GET", "POST"})
     */
    public function import(UserPasswordEncoderInterface $passwordEncoder, Request $request): Response
    {
        $file = $request->files->get('myfile');
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load($file);
        $data  = $spreadsheet->getActiveSheet()->toArray();
        $list = [];
        $entityManager = $this->getDoctrine()->getManager();
        foreach ($data as $key => $d) {
            $list[$key] = new Client();
            $list[$key]->setCode($d[0]);
            $list[$key]->setNom($d[1]);
            $list[$key]->setPrenom($d[1]);
            $list[$key]->setCommune($d[3]);
            $list[$key]->setCodePostal($d[4]);
            $list[$key]->setNumGSM($d[6]);
            $list[$key]->setDateInsertion(new \DateTime());
            $entityManager->persist($list[$key]);
            $entityManager->flush();
        }
        return $this->redirectToRoute('client_index');
    }
}
