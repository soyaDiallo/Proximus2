<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class VerificationController extends AbstractController
{
    /**
     * @Route("/verification", name="verification")
     */
    public function index()
    {
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
}
