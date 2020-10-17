<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code')
            ->add('dateInsertion')
            ->add('typeClient')
            ->add('nom')
            ->add('prenom')
            ->add('dateNaissance')
            ->add('nomSociete')
            ->add('numTVA')
            ->add('dateCreationSTE')
            ->add('numClientProximus')
            ->add('numTelephoneFixe')
            ->add('numGSM')
            ->add('email')
            ->add('numIBAN')
            ->add('codePostal')
            ->add('commune')
            ->add('rue')
            ->add('numPorte')
            ->add('adresseInstallation')
            ->add('dateInstallation')
            ->add('infoEncodage')
            ->add('numTelephoneProximus')
            ->add('numClientConcurrence')
            ->add('numEasySwitch')
            ->add('numCarteSIMPrepayee')
            ->add('nomClientMobile')
            ->add('codeClientMobile')
            ->add('appMobile')
            ->add('bonusTV')
            ->add('lienDrivePartageable')
            ->add('carteIdentite')
            ->add('fournisseur');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
