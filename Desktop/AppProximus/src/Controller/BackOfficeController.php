<?php

namespace App\Controller;

use App\Repository\BackOfficeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/backoffice")
 * @Security("is_granted('ROLE_BACKOFFICE')")
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
}
