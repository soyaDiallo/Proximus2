<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Agent;
use App\Entity\BackOffice;
use App\Entity\Superviseur;
use App\Entity\Administrateur;
use App\Form\RegistrationFormType;
use App\Security\UsersAuthenticathorAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, UsersAuthenticathorAuthenticator $authenticator): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $type = $form->get('roles')->getData();
            switch ($type[0]) {
                case "ROLE_AGENT":
                    $agent = new Agent();
                    $agent->setNom($user->getNom());
                    $agent->setPrenom($user->getPrenom());
                    $agent->setEmail($user->getEmail());
                    $agent->setCode($user->getCode());
                    $agent->setTel($user->getTel());
                    $agent->setPassword($user->getPassword());
                    $user = $agent;
                    $role = ['ROLE_AGENT'];
                    break;
                case 'ROLE_BACKOFFICE':
                    $back = new BackOffice();
                    $back->setNom($user->getNom());
                    $back->setPrenom($user->getPrenom());
                    $back->setEmail($user->getEmail());
                    $back->setCode($user->getCode());
                    $back->setTel($user->getTel());
                    $back->setPassword($user->getPassword());
                    $user = $back;
                    $role = ['ROLE_BACKOFFICE'];
                    break;
                case 'ROLE_SUPERVISEUR':
                    $super = new Superviseur();
                    $super->setNom($user->getNom());
                    $super->setPrenom($user->getPrenom());
                    $super->setEmail($user->getEmail());
                    $super->setCode($user->getCode());
                    $super->setTel($user->getTel());
                    $super->setPassword($user->getPassword());
                    $user = $super;
                    $role = ['ROLE_SUPERVISEUR'];
                    break;
                case 'ROLE_ADMINISTRATEUR':
                    $admin = new Administrateur();
                    $admin->setNom($user->getNom());
                    $admin->setPrenom($user->getPrenom());
                    $admin->setEmail($user->getEmail());
                    $admin->setCode($user->getCode());
                    $admin->setTel($user->getTel());
                    $admin->setPassword($user->getPassword());
                    $user = $admin;
                    $role = ['ROLE_ADMINISTRATEUR'];
                    break;

                default:
                    return $this->redirectToRoute('app_login');
                    break;
            }

            $user->setRoles($role);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
