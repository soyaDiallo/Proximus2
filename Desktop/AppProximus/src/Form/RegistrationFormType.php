<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = new User();
        $builder
            ->add('roles', ChoiceType::class, [
                'label' => 'Rôle Compte',
                'choices' => $user->getRolesList(),
                'multiple' => false
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'Adresse Email',
                ],
                'label' => "Adresse Email"
            ])
            ->add('plainPassword', RepeatedType::class, array(
                'mapped' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe de confirmation doit être identique au mot de passe',
                'options' => array(
                    'attr' => array(
                        'placeholder' => 'Mot de passe'
                    )
                ),
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmation mot de passe'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le mot de passe ne doit pas être vide',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Le mot de passe doit avoir au moins {{ limit }} caractères',
                        'max' => 255,
                    ]),
                ]
            ))
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
            ->add('code', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le code ne doit pas être vide',
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

        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    // transform the array to a string
                    return count($rolesArray) ? $rolesArray[0] : null;
                },
                function ($rolesString) {
                    // transform the string back to an array
                    return [$rolesString];
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
