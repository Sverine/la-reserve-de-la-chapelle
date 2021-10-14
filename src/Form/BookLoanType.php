<?php

namespace App\Form;

use App\Entity\BookLoan;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Type as TypeConstraint;

class BookLoanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_reserved',DateTimeType::class,[
                'label'=>'Date et heure de la réservation',
                'date_widget'=>'single_text',
                'time_widget'=>'single_text',
                'disabled'=>true,
                'constraints'=>[
                    new TypeConstraint(['DateTimeInterface'])
                ]
            ])
            ->add('status',ChoiceType::class,[
                'label'=>'Statut',
                'attr'=>['class'=>'input-js'],
                'choices'=>[
                    'Réservé'=>'Réservé',
                    'Emprunté'=>'Emprunté',
                    'Rendu'=>'Rendu',
                ],
                'constraints'=>[
                    new Choice([
                        'Emprunté', 'Rendu'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BookLoan::class,
        ]);
    }
}
