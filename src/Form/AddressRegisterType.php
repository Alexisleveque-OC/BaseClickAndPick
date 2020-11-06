<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address',null,[
                'label' => 'Votre adresse',
                'attr' => [ 'placeholder' => '1 rue jean cocteau']
            ])
            ->add('complement',null,[
                'label' => 'complément d\'adresse (facultatif)' ,
                'attr' => [ 'placeholder' => 'Bis, Ter ...']
            ])
            ->add('zipCode',null,[
                'label' => 'Code Postal',
                'attr' => [ 'placeholder' => '17012']
            ])
            ->add('city',null,[
                'label' => 'Ville',
                'attr' => [ 'placeholder' => 'Mavilleamoi']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
