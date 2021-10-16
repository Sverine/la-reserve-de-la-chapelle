<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type as TypeConstraint;
use Vich\UploaderBundle\Form\Type\VichFileType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,[
                'label'=>'Titre',
                'constraints' => [
                    new Length([
                        'min'=> 2,
                        'max'=>50,
                        'minMessage'=>'Le nom du livre est trop court',
                        'maxMessage'=>'Le nom du livre est trop long',
                        ]),
                    new TypeConstraint(['string'])
                ]
            ])
            ->add('author', TextType::class,[
                'label'=>'Auteur',
                'constraints'=>[
                    new Length([
                        'min'=>2,
                        'max'=>30,
                        'minMessage'=>'Le nom de l\'auteur est trop court',
                        'maxMessage'=>'Le nom de l\'auteur est trop long',
                        ]),
                    new TypeConstraint(['string'])
                ]
            ])
            ->add('published_at', DateType::class,[
                'label'=>'Date de publication',
                'widget'=>'single_text',
                'constraints'=>[
                    new NotBlank(['message'=>'La date de publication doit être renseignée']),
                    new TypeConstraint(['DateTimeInterface'])
                ]
            ])
            ->add('folderImage',VichFileType::class,[
                'label'=>'Image de couverture',
                'allow_delete' => false,
                'required' => false
            ])

            ->add('type', EntityType::class,[
                'class'=>Type::class,
                'choice_label'=>'name',
                'multiple'=>true,
                'expanded'=>true,
                'constraints' => [
                    new NotBlank(['message'=>'Le type du livre doit être renseigné'])
                ]

            ])
            ->add('is_favorite', CheckboxType::class,[
                'label'=>'Afficher le livre en coup de coeur',
                'required'=>false,

            ])
            ->add('description', TextareaType::class,[
                'label'=>'Description',
                'constraints' => [
                    new Length([
                        'min'=> 2,
                        'max'=>2500,
                        'minMessage'=>'La description est trop courte',
                        'maxMessage'=>'La description est trop longue',
                        ]),
                    new TypeConstraint(['string'])
                ]

            ])
            ->add('submit', SubmitType::class,[
                'label'=>'Enregistrer',
                'attr'=>[
                    'class'=>'w-100 mt-5 btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
