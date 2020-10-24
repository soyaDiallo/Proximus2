<?php

namespace App\Form;

use App\Entity\Raison;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;

class RaisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('motif', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le motif ne doit pas être vide',
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Raison::class,
        ]);
    }
}
