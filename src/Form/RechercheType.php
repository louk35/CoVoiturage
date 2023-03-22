<?php

namespace App\Form;

use App\Entity\Trajet;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class RechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lieuDepart',TextType::class,['label'=> 'ville de départ'])
            ->add('lieuArrive',TextType::class,['label'=> 'ville d\' arrivée'])
            ->add('dateDepart',DateTimeType::class,['label'=> 'Date'])
            // ->add('lieuDepart', EntityType::class, [
            //     'class' => Trajet::class,
            //     'query_builder' => function (EntityRepository $er) {
            //         return $er->createQueryBuilder('t')
            //             ->groupBy('t.lieuDepart')
            //             ->orderBy('t.lieuDepart', 'ASC');
            //     },
            //     'choice_label' => 'lieuDepart',
            //     'required' => true,
            // ])
            // ->add('lieuArrive', EntityType::class, [
            //     'class' => Trajet::class,
            //     'query_builder' => function (EntityRepository $er) {
            //         return $er->createQueryBuilder('t')
            //             ->groupBy('t.lieuArrive')
            //             ->orderBy('t.lieuArrive', 'ASC');
            //     },
            //     'choice_label' => 'lieuArrive',
            //     'required' => true,
            // ])

            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trajet::class,
        ]);
    }
}
