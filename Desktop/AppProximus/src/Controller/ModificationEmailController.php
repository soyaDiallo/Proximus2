<?php

namespace App\Controller;
use App\Form\ModificationEmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/users")
 */
class ModificationEmailController extends AbstractController
{
    /**
     * @Route("/modification/email", name="modification_email")
     */
    public function index(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(ModificationEmailType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('administrateur_index');
        }
        return $this->render('modification_email/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
