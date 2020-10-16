<?php

namespace App\Controller;
use App\Form\ModifierPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ResetType;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @Route("/users")
 */
class ModifierPasswordController extends AbstractController
{
    /**
     * @Route("/modifier/password", name="modifier_password")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $form = $this->createForm(ModifierPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $request->request->get('modifier_password')['oldPassword'];
            $newPassword = $request->request->get('modifier_password')['plainPassword']['first'];
            $confirmPassword = $request->request->get('modifier_password')['plainPassword']['second'];
            if($newPassword !== $confirmPassword) {
              $this->addFlash('error', 'the two passwords id not mutch pls enter correct');
              return $this->redirect($request->getUri());
            }
            if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {
              $newEncodedPassword = $passwordEncoder->encodePassword($user, $newPassword);
              $user->setPassword($newEncodedPassword);
              $em->persist($user);
              $em->flush();
              return $this->redirectToRoute('app_logout');
            } else {
              $this->addFlash('error', 'old password is wrong !');
              return $this->redirect($request->getUri());
            }
        }
        return $this->render('modifier_password/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
