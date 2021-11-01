<?php

namespace App\Form;

use App\Entity\Artist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
                    'placeholder' => 'Saisir la nationalité'
                ],
            ])
            ->add('photo', FileType::class, [
                'label' => 'Image*',
                'data_class' => null,
                'required' => true,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artist::class,
        ]);
    }
}
