<?php

namespace App\Controller;

use App\Repository\SuperviseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/superviseur")
 * @Security("is_granted('ROLE_SUPERVISEUR')")
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
}
