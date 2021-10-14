<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type as TypeConstraint;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class,[
                'label'=>'Prénom',
                'attr'=>[
                    'placeholder'=>'Dwight'
                ],
                'constraints' => [
                    new Length([
                        'min'=> 2,
                        'max'=>20,
                        'minMessage'=>'Le prénom est trop court',
                        'maxMessage'=>'Le prénom est trop long',
                    ]),
                    new TypeConstraint(['string'])
                ]
            ])
            ->add('lastname', TextType::class,[
                'label'=>'Nom de famille',
                'attr'=>[
                    'placeholder'=>'Schrute'
                ],
                'constraints' => [
                    new Length([
                        'min'=> 2,
                        'max'=>20,
                        'minMessage'=>'Le nom de famille est trop court',
                        'maxMessage'=>'Le nom de famille est trop long',
                    ]),
                    new TypeConstraint(['string'])
                ]
            ])
            ->add('address', TextareaType::class,[
                'label'=>'Adresse',
                'attr'=>[
                    'placeholder'=>
                    '8 avenue Calypso
34000 Curreau-sur-Seine'
                ],
                'constraints' => [
                    new Length([
                        'min'=> 10,
                        'max'=>100,
                        'minMessage'=>'L\'adresse est trop courte',
                        'maxMessage'=>'L\'adresse est trop longue',
                    ]),
                    new TypeConstraint(['string'])
                ]
            ])
            ->add('date_birth', DateType::class,[
                'label'=>'Date de naissance',
                'widget'=>'single_text',
                'constraints'=>[
                    new NotBlank(['message'=>'La date de publication doit être renseignée']),
                    new TypeConstraint(['DateTimeInterface'])
                ]
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
                'constraints'=>[
                    new Email(['message'=>'L\'adresse email n\'est pas valide']),
                    new NotBlank(['message'=>'L\'email doit être renseigné'])
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
                ],
                'constraints'=>[
                    new Length([
                        'min'=>5,
                        'max'=>60,
                        'minMessage'=>'Le mot de passe est trop court'
                    ])
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
