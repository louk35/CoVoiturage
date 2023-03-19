<?php

namespace App\Form;

use App\Entity\Trajet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class TrajetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lieuDepart', TextType::class, [
                'constraints' => [new NotBlank(),
                    new Length(['max' => 255]),
                ]
            ])
            ->add('lieuArrive', TextType::class,[
        'constraints' => [new NotBlank(),
            new Length(['max' => 255]),
        ]
    ])
            ->add('dateDepart', DateTimeType::class)
            ->add('dateArrive', DateTimeType::class)
            ->add('prix', TextType::class,[
                'constraints' => [new NotBlank(),
                    new Length(['max' => 255]),
                ]
            ])
            ->add('modelVoiture', TextType::class ,[
                'constraints' => [new NotBlank(),
                    new Length(['max' => 255]),
                ]
            ])
            ->add('nbplace', TextType::class,[
                'constraints' => [new NotBlank(),
                    new Length(['max' => 255]),
                ]
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [new NotBlank(),
                    new Length(['max' => 255]),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trajet::class,
        ]);
    }
}
