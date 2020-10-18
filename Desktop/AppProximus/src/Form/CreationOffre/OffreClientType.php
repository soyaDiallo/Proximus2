<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class OffreClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code')
            ->add('typeClient', ChoiceType::class, [
                'choices' => [
                    'Business To Business (BTB)' => "BTB",
                    'Business To Consumer (BTC)' => "BTC"
                ]
            ])
            ->add('nom')
            ->add('prenom')
            ->add('dateNaissance', DateTimeType::class, ['widget' => 'single_text'])
            ->add('nomSociete')
            ->add('numTVA')
            ->add('dateCreationSTE', DateTimeType::class, ['widget' => 'single_text'])
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
            ->add('dateInstallation', DateTimeType::class, ['widget' => 'single_text'])
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
