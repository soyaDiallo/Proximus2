<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ModificationPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, array(
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Ancien Mot de passe',
                ],
                'label' => 'Ancien Mot de passe'
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'mapped' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe de confirmation doit être identique au mot de passe',
                'options' => array(
                    'attr' => array(
                        'placeholder' => 'Nouveau Mot de passe'
                    )
                ),
                'first_options'  => ['label' => 'Nouveau Mot de passe'],
                'second_options' => ['label' => 'Confirmation Mot de passe'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le mot de passe ne doit pas être vide',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Le nom doit avoir au moins {{ limit }} caractères ',
                        'max' => 255,
                    ]),
                ]
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
