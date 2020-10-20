<?php

namespace App\Controller;

use App\Form\RechercheClientType;
use App\Repository\AgentRepository;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/agent")
 * @Security("is_granted('ROLE_AGENT')")
 */
class AgentController extends AbstractController
{
    /**
     * @Route("/", name="agent_index", methods={"GET", "POST"})
     */
    public function index(ClientRepository $clientRepository, AgentRepository $agentRepository, Request $request): Response
    {
        $form = $this->createForm(RechercheClientType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $code = strtoupper($form->get('recherche')->getData());
            $client = $clientRepository->findByCode($code)[0];

            if (!empty($client)) {
                return $this->redirectToRoute('offer_new', [
                    'id' => $client->getId()
                ]);
            } else {
                $this->addFlash('error_get_client', 'Le Client que vous cherchez n\'existe pas');
                return $this->redirect($request->getUri());
            }
        }
        return $this->render('agent/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
