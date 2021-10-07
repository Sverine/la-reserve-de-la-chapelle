<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,[
                'label'=>'Titre'
            ])
            ->add('author', TextType::class,[
                'label'=>'Auteur'
            ])
            ->add('published_at', DateType::class,[
                'label'=>'Date de publication',
                'widget'=>'single_text'
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
                'expanded'=>true
            ])
            ->add('is_favorite', CheckboxType::class,[
                'label'=>'Afficher le livre en coup de coeur',
                'required'=>false,

            ])
            ->add('description', TextareaType::class,[
                'label'=>'Description'
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
