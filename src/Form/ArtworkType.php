<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\Category;
use App\Entity\Event;
use App\Entity\Artwork;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArtworkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'label' => 'Titre de l\'oeuvre*',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ajouter le titre',
                ],
            ])
            ->add('picture', FileType::class, [
                'label' => 'Image*',
                'data_class' => null,
                'required' => true,
            ])
            ->add('height', null, [
                'label' => 'Hauteur (en cm)',
                'attr' => [
                    'placeholder' => 'Ajouter une hauteur',
                ],
            ])
            ->add('width', null, [
                'label' => 'Largeur (en cm)',
                'attr' => [
                    'placeholder' => 'Ajouter une largeur',
                ],
            ])
            ->add('depth', null, [
                'label' => 'Profondeur (en cm)',
                'attr' => [
                    'placeholder' => 'Ajouter une profondeur',
                ],
            ])
            ->add('description', null, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Ajouter une description',
                ],
            ])
            ->add('artists', null, [
                'label' => 'Artiste*',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ajouter un artiste',
                ],
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'label' => 'Catégorie(s)*',
                'required' => true,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artwork::class,
        ]);
    }
}
