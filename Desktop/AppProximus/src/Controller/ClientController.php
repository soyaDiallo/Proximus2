<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

/**
 * @Route("/client")
 */
class ClientController extends AbstractController
{
    /**
     * @Route("/", name="client_index", methods={"GET"})
     */
    public function index(ClientRepository $clientRepository): Response
    {
        return $this->render('client/index.html.twig', [
            'clients' => $clientRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="client_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('client_index');
        }

        return $this->render('client/new.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="client_show", methods={"GET"})
     */
    public function show(Client $client): Response
    {
        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="client_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Client $client): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_index');
        }

        return $this->render('client/edit.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="client_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Client $client): Response
    {
        if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($client);
            $entityManager->flush();
        }

        return $this->redirectToRoute('client_index');
    }

    /**
     * @Route("/excel/{id}", name="excel", methods={"GET","POST"})
     */
    public function GenererExcel(Request $request,Client $client): Response
    {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            //couleur colonne
            $evenRow = [
                'fill'=>[
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => 'a6a6a6'
                    ]
                ]
            ];

            
            // set font par defaut
            $spreadsheet->getDefaultStyle()
            ->getFont()
            ->setName('Arial')
            ->setSize(12);

            $sheet->setCellValue('A1', 'Descriptif');
            $sheet->setCellValue('B1', '');
            // set font style de l'entete
            $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
            // set cell alignment
            $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            //setting column width
            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(70);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(70);

            // remplissage des cellules
            $sheet->setCellValue('A2', "Nom du client");
            $sheet->setCellValue('B2', $client->getNom());
            $sheet->setCellValue('A3', "Prénom du client");
            $sheet->setCellValue('B3', $client->getPrenom());
            $sheet->setCellValue('A4', "Date de naissance");
            $sheet->setCellValue('B4', $client->getDateNaissance());
            $sheet->setCellValue('A5', "Nom de la société");
            $sheet->setCellValue('B5', $client->getNomSociete());
            $sheet->setCellValue('A6', "N° de TVA");
            $sheet->setCellValue('B6', $client->getNumTVA());
            $sheet->setCellValue('A7', "Date de Création STE");
            $sheet->setCellValue('B7', $client->getDateCreationSTE());
            $sheet->setCellValue('A8', "N° de client Proximus (si existant)");
            $sheet->setCellValue('B8', $client->getNumClientProximus());
            $sheet->setCellValue('A9', "Numéro de téléphone fixe");
            $sheet->setCellValue('B9', $client->getNumTelephoneFixe());
            $sheet->setCellValue('A10', "Numéro de N° de GSM");
            $sheet->setCellValue('B10', $client->getNumGSM());
            $sheet->setCellValue('A11', "Adresse mail");
            $sheet->setCellValue('B11', $client->getEmail());
            $sheet->setCellValue('A12', "num IBAN ( si JO)");
            $sheet->setCellValue('B12', $client->getNumIBAN());
            $sheet->setCellValue('A13', "Code postal");
            $sheet->setCellValue('B13', $client->getCodePostal());
            $sheet->setCellValue('A14', "Commune");
            $sheet->setCellValue('B14', $client->getCommune());
            $sheet->setCellValue('A15', "Nom de rue, numéro de porte");
            $sheet->setCellValue('B15', $client->getRue().' ,'.$client->getNumPorte());
            $sheet->setCellValue('A16', "Si elle est différent, adresse d'installation des services");
            $sheet->setCellValue('B16', $client->getAdresseInstallation());
            $sheet->setCellValue('A17', "Produit(s) existant(s) Proximus");
            $sheet->setCellValue('B17', '');
            $sheet->setCellValue('A18', "Produit(s) à la concurrence");
            $sheet->setCellValue('B18', '');
            $sheet->setCellValue('A19', "Produit(s) vendu(s)");
            $sheet->setCellValue('B19', '');
            $sheet->setCellValue('A20', "Prix Plein et Prix Promos");
            $sheet->setCellValue('B20', '');
            $sheet->setCellValue('A21', "Dates d'installation souhaitées (3)");
            $sheet->setCellValue('B21', $client->getDateInstallation());
            $sheet->setCellValue('A22', "Information pour l’encodage");
            $sheet->setCellValue('B22', $client->getInfoEncodage());
            $sheet->setCellValue('A23', "N° de téléphone (fixe et/ou mobile) à porter vers Proximus");
            $sheet->setCellValue('B23', $client->getNumTelephoneProximus());
            $sheet->setCellValue('A24', "N° de client chez la concurrence");
            $sheet->setCellValue('B24', $client->getNumClientConcurrence());
            $sheet->setCellValue('A25', "N° d'easy switch");
            $sheet->setCellValue('B25', $client->getNumEasySwitch());
            $sheet->setCellValue('A26', "N° de carte sim du/des numéro(s) de GSM à porter (seulement si carte prépayée)");
            $sheet->setCellValue('B26', $client->getNumCarteSIMPrepayee());
            $sheet->setCellValue('A27', "nom client mobile concurrence et code client");
            $sheet->setCellValue('B27', $client->getNomClientMobile());
            $sheet->setCellValue('A28', "choix de l'app pour le mobile (Facebook, etc)");
            $sheet->setCellValue('B28', $client->getAppMobile());
            $sheet->setCellValue('A29', "Bonus TV / bouquet");
            $sheet->setCellValue('B29', $client->getBonusTV());
            $sheet->setCellValue('A30', "lien partageable de l'enregistrement (drive)");
            $sheet->setCellValue('B30', $client->getLienDrivePartageable());
            $sheet->setCellValue('A31', "Carte Identité");
            $sheet->setCellValue('B31', $client->getCarteIdentite());
            $sheet->setCellValue('A32', "Commentaire");
            $sheet->setCellValue('B32', '');

            // application de la couleur
            $spreadsheet->getActiveSheet()->getStyle('A1:A32')->applyFromArray($evenRow);
            //border
            $spreadsheet->getActiveSheet()->getStyle('A1:B32')->getBorders()->applyFromArray(
                [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => [
                        'rgb' => '000000'
                        ]
                    ]
                ]
            );
            // creation
            $writer = new Xlsx($spreadsheet);
            $writer->save('Fiche descriptive de '.$client->getPrenom().' '.$client->getNom().'.xlsx');
            
            return $this->render('client/show.html.twig', [
                'client' => $client,
            ]);
    }

    /**
     * @Route("/voir/{id}", name="voir_excel", methods={"GET","POST"})
     */
    public function voirExcel(Request $request,Client $client): Response
    {
        $spreadsheet = new Spreadsheet();
            
        $reader = IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load('Fiche descriptive de soya diallo.xlsx');
        $writer = IOFactory::createWriter($spreadsheet, 'Html');
        $writer->save('php://output');
        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }
}
