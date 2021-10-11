<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class,[
                'label'=>'Prénom',
                'attr'=>[
                    'placeholder'=>'Dwight'
                ]
            ])
            ->add('lastname', TextType::class,[
                'label'=>'Nom de famille',
                'attr'=>[
                    'placeholder'=>'Schrute'
                ]
            ])
            ->add('address', TextareaType::class,[
                'label'=>'Adresse',
                'attr'=>[
                    'placeholder'=>
                    '8 avenue Calypso
34000 Curreau-sur-Seine'
                ]
            ])
            ->add('date_birth', DateType::class,[
                'label'=>'Date de naissance',
                'widget'=>'single_text'
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Employé' => 'ROLE_EMPLOYE',
                    'Admin' => 'ROLE_ADMIN',
                ],
                'expanded'=>true,
                'multiple'  => true, // choix multiple
            ])
            ->add('email', EmailType::class,[
                'label'=>'Email',
                'attr'=>[
                    'placeholder'=>'dwight.schrute@la-reserve.com'
                ]
            ])
            ->add('password', RepeatedType::class,[
                'type'=> PasswordType::class,
                'invalid_message'=> 'Les mots de passe ne sont pas identiques',
                'first_options'=>[
                    'label'=>'Mot de passe'
                ],
                'second_options'=>[
                    'label'=>'Confirmer le mot de passe'
                ]
            ])
            ->add('submit', SubmitType::class,[
                'label'=>"S'INSCRIRE",
                'attr'=>[
                    'class'=>'w-100 mt-5 btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
