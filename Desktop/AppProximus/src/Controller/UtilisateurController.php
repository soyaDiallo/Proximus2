<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Entity\User;
use App\Entity\Agent;
use App\Entity\BackOffice;
use App\Entity\Superviseur;
use App\Entity\Administrateur;
use App\Form\EditRegistrationFormType;
use App\Form\RegistrationFormType;
use App\Security\UsersAuthenticathorAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


/**
 * @Route("/utilisateurs")
 * @Security("is_granted('ROLE_ADMINISTRATEUR')")
 */
class UtilisateurController extends AbstractController
{
    /**
     * @Route("/", name="utilisateur_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        //  dd($userRepository->findAll());

        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/modifier/{id}", name="utilisateur_edit", methods={"GET", "POST"})
     */
    public function edit(UserRepository $userRepository, int $id = 0, Request $request): Response
    {
        $user = $userRepository->find($id);
        $form = $this->createForm(EditRegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('utilisateur_index');
        }

        return $this->render('utilisateur/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/import", name="import_user", methods={"GET", "POST"})
     */
    public function import(UserPasswordEncoderInterface $passwordEncoder, Request $request): Response
    {
        $file = $request->files->get('myfile');
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load($file);
        $data  = $spreadsheet->getActiveSheet()->toArray();
        //dd($data);
        $list=[];
        $entityManager = $this->getDoctrine()->getManager();
        foreach($data as $key => $d)
        {
            //dd($d[]); 
            switch ($d[6]) {
                case "agent":
                    $list[$key] = new Agent();
                    $list[$key]->setCode($d[0]);
                    $list[$key]->setNom($d[1]);
                    $list[$key]->setPrenom($d[2]);
                    $list[$key]->setEmail($d[3]);
                    $list[$key]->setPassword($passwordEncoder->encodePassword($list[$key],$d[4]));
                    $list[$key]->setTel($d[5]);
                    $list[$key]->setRoles(["ROLE_AGENT"]);
                    $entityManager->persist($list[$key]);      
                    $entityManager->flush();
                    break;
                case 'back-office':
                    $list[$key] = new BackOffice();
                    $list[$key]->setCode($d[0]);
                    $list[$key]->setNom($d[1]);
                    $list[$key]->setPrenom($d[2]);
                    $list[$key]->setEmail($d[3]);
                    $list[$key]->setPassword($passwordEncoder->encodePassword($list[$key],$d[4]));
                    $list[$key]->setTel($d[5]);
                    $list[$key]->setRoles(["ROLE_BACKOFFICE"]);
                    $entityManager->persist( $list[$key]);      
                    $entityManager->flush();
                    break;
                case 'superviseur':
                    $list[$key] = new Superviseur();
                    $list[$key]->setCode($d[0]);
                    $list[$key]->setNom($d[1]);
                    $list[$key]->setPrenom($d[2]);
                    $list[$key]->setEmail($d[3]);
                    $list[$key]->setPassword($passwordEncoder->encodePassword($list[$key],$d[4]));
                    $list[$key]->setTel($d[5]);
                    $list[$key]->setRoles(["ROLE_SUPERVISEUR"]);
                    $entityManager->persist( $list[$key]);      
                    $entityManager->flush();
                    break;
                case 'admin':
                    $list[$key] = new Administrateur();
                    $list[$key]->setCode($d[0]);
                    $list[$key]->setNom($d[1]);
                    $list[$key]->setPrenom($d[2]);
                    $list[$key]->setEmail($d[3]);
                    $list[$key]->setPassword($passwordEncoder->encodePassword($list[$key],$d[4]));
                    $list[$key]->setTel($d[5]);
                    $list[$key]->setRoles(["ROLE_ADMINISTRATEUR"]);
                    $entityManager->persist( $list[$key]);      
                    $entityManager->flush();
                    break;

                default:
                    return $this->redirectToRoute('utilisateur_index');
                    break;
            }
        }    
        return $this->redirectToRoute('utilisateur_index');
    }

    /**
     * @Route("/nouveau", name="utilisateur_new")
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, UsersAuthenticathorAuthenticator $authenticator): Response
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

            return $this->redirectToRoute('utilisateur_index');
        }

        return $this->render('utilisateur/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
