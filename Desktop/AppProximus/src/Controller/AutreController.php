<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Entity\Categorie;
use App\Entity\Raison;
use App\Form\CategorieType;
use App\Form\RaisonType;
use App\Repository\CategorieProduitRepository;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use App\Repository\RaisonRepository;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/autres")
 * @Security("is_granted('ROLE_ADMINISTRATEUR')")
 */
class AutreController extends AbstractController
{
    /**
     * @Route("/", name="autre_index", methods={"GET", "POST"})
     */
    public function index(Request $request, RaisonRepository $raisonRepository): Response
    {
        $raison = new Raison();
        $form = $this->createForm(RaisonType::class, $raison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($raison);
            $entityManager->flush();

            return $this->redirectToRoute('autre_index');
        }

        return $this->render('autre/index.html.twig', [
            'raison' => $raison,
            'raisons' => $raisonRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }
}
