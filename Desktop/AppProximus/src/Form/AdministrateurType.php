<?php

namespace App\Form;

use App\Entity\Administrateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AdministrateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'L\'email ne doit pas être vide',
                    ]),
                    new Email([
                        'message' => '{{ value|capitalize }} n\'est pas un email valide',
                    ]),
                ]
            ])
            ->add('code', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le code ne doit pas être vide',
                    ])
                ]
            ])
            ->add('nom', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nom ne doit pas être vide',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Le nom doit avoir au moins 3 caractères',
                        'max' => 255,
                    ])
                ]
            ])
            ->add('prenom', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le prénom ne doit pas être vide',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Le prénom doit avoir au moins 3 caractères',
                        'max' => 255,
                    ])
                ]
            ])
            ->add('tel', TelType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le téléphone ne doit pas être vide',
                    ]),
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Administrateur::class,
        ]);
    }
}
