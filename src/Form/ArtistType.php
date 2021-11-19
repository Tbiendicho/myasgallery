<?php

namespace App\Form;

use App\Entity\Artist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArtistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom de l\'artiste*',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Saisir un nom'
                ],
            ])
            ->add('biography', null, [
                'label' => 'A propos de l\'artiste*',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Parler de l\'artiste'
                ],
            ])
            ->add('country', null, [
                'label' => 'Nationalité*',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Saisir une nationalité'
                ],
            ])

            // using the vich bundle to load files
            ->add('photo', VichImageType::class, [
                'label' => 'Photo*',
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
                'image_uri' => false,
                'asset_helper' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artist::class,
        ]);
    }
}
