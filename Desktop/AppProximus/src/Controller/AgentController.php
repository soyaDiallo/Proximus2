<?php

namespace App\Controller;

use App\Entity\Agent;
use App\Form\AgentType;
use App\Form\RechercheClientType;
use App\Repository\AgentRepository;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
/**
 * @Route("/agent")
 */
class AgentController extends AbstractController
{
    /**
    * @Route("/", name="agent_index", methods={"GET","POST"})
    * 
    */
   public function index(ClientRepository $clientRepository,AgentRepository $agentRepository,Request $request): Response
   {
       $form = $this->createForm(RechercheClientType::class);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
           $code=$form->get('recherche')->getData();

           return $this->render('client/show.html.twig', [
               'client' => $clientRepository->findByCode($code)[0],
           ]);
       }
       return $this->render('agent/index.html.twig', [
           'form' => $form->createView(),
       ]);
   }

    /**
     * @Route("/new", name="agent_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $agent = new Agent();
        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($agent);
            $entityManager->flush();

            return $this->redirectToRoute('agent_index');
        }

        return $this->render('agent/new.html.twig', [
            'agent' => $agent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="agent_show", methods={"GET"})
     */
    public function show(Agent $agent): Response
    {
        return $this->render('agent/show.html.twig', [
            'agent' => $agent,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="agent_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Agent $agent): Response
    {
        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('agent_index');
        }

        return $this->render('agent/edit.html.twig', [
            'agent' => $agent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="agent_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Agent $agent): Response
    {
        if ($this->isCsrfTokenValid('delete'.$agent->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($agent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('agent_index');
    }
}
