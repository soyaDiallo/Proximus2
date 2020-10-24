<?php

namespace App\Controller;

use App\Form\AdministrateurType;
use App\Form\AgentType;
use App\Form\BackOfficeType;
use App\Form\ModificationEmailType;
use App\Form\ModificationPasswordType;
use App\Form\SuperviseurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/profil")
 * @Security("is_granted('ROLE_USER')")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/", name="profile_index", methods={"GET", "POST"})
     */
    public function index(Request $request): Response
    {
        $user = $this->getUser();
        $role = $this->getUser()->getRoles();
        $form = null;
        
        switch ($role[0]) {
            case "ROLE_AGENT":
                $form = $this->createForm(AgentType::class, $user, [
                    'action' => $this->generateUrl('profile_index'),
                    'method' => 'POST',
                ]);
                break;
            case 'ROLE_BACKOFFICE':
                $form = $this->createForm(BackOfficeType::class, $user, [
                    'action' => $this->generateUrl('profile_index'),
                    'method' => 'POST',
                ]);
                break;
            case 'ROLE_SUPERVISEUR':
                $form = $this->createForm(SuperviseurType::class, $user, [
                    'action' => $this->generateUrl('profile_index'),
                    'method' => 'POST',
                ]);
                break;
            case 'ROLE_ADMINISTRATEUR':
                $form = $this->createForm(AdministrateurType::class, $user, [
                    'action' => $this->generateUrl('profile_index'),
                    'method' => 'POST',
                ]);
                break;
            default:
                return $this->redirectToRoute('app_login');
                break;
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('profil/personal.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/compte", name="profile_account_index", methods={"GET", "POST"})
     */
    public function index_account(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ModificationEmailType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('profil/account.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/password", name="profile_password_index", methods={"GET", "POST"})
     */
    public function index_password(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $form = $this->createForm(ModificationPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $request->request->get('modification_password')['oldPassword'];
            $newPassword = $request->request->get('modification_password')['plainPassword']['first'];
            $confirmPassword = $request->request->get('modification_password')['plainPassword']['second'];

            if ($newPassword !== $confirmPassword) {
                $this->addFlash('error', 'Le mot de passe de confirmation doit être identique au mot de passe');
                return $this->redirect($request->getUri());
            }

            if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {
                $newEncodedPassword = $passwordEncoder->encodePassword($user, $newPassword);
                $user->setPassword($newEncodedPassword);
                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute('app_logout');
            } else {
                $this->addFlash('error', 'L\'ancien mot de passe est incorrect');
                return $this->redirect($request->getUri());
            }
        }

        return $this->render('profil/password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
