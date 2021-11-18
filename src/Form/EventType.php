<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\Artwork;
use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

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
            ->add('picture', VichImageType::class, [
                'label' => 'Image*',
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
                'image_uri' => false,
                'asset_helper' => true,
            ])
            ->add('information', null, [
                'label' => 'Description*',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ajouter une description',
                ],
            ])
            ->add('date', null, [
                'label' => 'Date de début*',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ajouter une date de début',
                ],
            ])
            ->add('dateEnd', null, [
                'label' => 'Date de fin',
                'attr' => [
                    'placeholder' => 'Ajouter une date de fin',
                ],
            ])
            ->add('link', null, [
                'label' => 'URL de l\'événement',
                'attr' => [
                    'placeholder' => 'Ajouter un lien',
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
                'attr' => [
                    'placeholder' => 'Ajouter une longitude',
                ],
            ])
            ->add('roadnumber', null, [
                'label' => 'Numéro de rue',
                'attr' => [
                    'placeholder' => 'Ajouter un numéro de rue',
                ],
            ])
            ->add('roadname', null, [
                'label' => 'Adresse*',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ajouter une adresse',
                ],
            ])
            ->add('roadname2', null, [
                'label' => 'Complément d\'adresse',
                'attr' => [
                    'placeholder' => 'Ajouter un complément',
                ],
            ])
            ->add('zipcode', null, [
                'label' => 'Code Postal*',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ajouter un code postal',
                ],
            ])
            ->add('town', null, [
                'label' => 'Ville*',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ajouter une ville',
                ],
            ])
            ->add('country', null, [
                'label' => 'Pays*',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ajouter un pays',
                ],
            ])
            ->add('artworks', EntityType::class, [
                'class' => Artwork::class,
                'label' => 'Oeuvres présentes',
                'choice_label' => 'title',
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('artists', EntityType::class, [
                'class' => Artist::class,
                'label' => 'Artistes exposés',
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
