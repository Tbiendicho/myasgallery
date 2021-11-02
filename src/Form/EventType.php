<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\Artwork;
use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpClient\Chunk\InformationalChunk;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom de l\'événement*',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ajouter le nom',
                ],
            ])
            ->add('information', null, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Ajouter une description',
                ],
            ])
            ->add('date', null, [
                'label' => 'Date',
                'attr' => [
                    'placeholder' => 'Ajouter une largeur',
                ],
            ])
            ->add('link', null, [
                'label' => 'URL de l\'événement',
                'attr' => [
                    'placeholder' => 'Ajouter une profondeur',
                ],
            ])
            ->add('latitude', null, [
                'label' => 'Latitude',
                'attr' => [
                    'placeholder' => 'Ajouter une latitude',
                ],
            ])
            ->add('longitude', null, [
                'label' => 'Longitude',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ajouter une longitude',
                ],
            ])
            ->add('roadnumber', null, [
                'label' => 'Numéro de rue',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ajouter une longitude',
                ],
            ])
            ->add('roadname', null, [
                'label' => 'Adresse',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ajouter une longitude',
                ],
            ])
            ->add('roadname2', null, [
                'label' => 'Complément d\'adresse',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ajouter une longitude',
                ],
            ])
            ->add('zipcode', null, [
                'label' => 'Code Postal',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ajouter un code postal',
                ],
            ])
            ->add('town', null, [
                'label' => 'Ville',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ajouter une ville',
                ],
            ])
            ->add('country', null, [
                'label' => 'Pays',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ajouter un pays',
                ],
            ])
            ->add('artworks', EntityType::class, [
                'class' => Artwork::class,
                'label' => 'Oeuvres présentes',
                'required' => true,
                'choice_label' => 'title',
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('artists', EntityType::class, [
                'class' => Artist::class,
                'label' => 'Artistes exposés',
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
            // Configure your form options here
        ]);
    }
}
