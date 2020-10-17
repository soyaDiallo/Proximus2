<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            $role = $this->getUser()->getRoles();
            switch ($role[0]) {
                case "ROLE_AGENT":
                    return $this->redirectToRoute('agent_index');
                    break;
                case 'ROLE_BACKOFFICE':
                    return $this->redirectToRoute('back_office_index');
                    break;
                case 'ROLE_SUPERVISEUR':
                    return $this->redirectToRoute('superviseur_index');
                    break;
                case 'ROLE_ADMINISTRATEUR':
                    return $this->redirectToRoute('administrateur_index');
                    break;

                default:
                    return $this->redirectToRoute('app_login');
                    break;
            }
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
