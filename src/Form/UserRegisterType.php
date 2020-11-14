<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class,[
                'label' => 'Votre nom et prénom.',
                'attr' => [ 'placeholder' => 'Durand Nicolas']
            ])
            ->add('email', EmailType::class,[
                'label' => 'Votre adresse email',
                'attr' => [ 'placeholder' => 'coucou@exemple.com']
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => ['placeholder' => 'Mot de passe']
                ],
                'second_options' => [
                    'label' => 'Confirmation de mot de passe',
                    'attr' => ['placeholder' => 'Confirmation du mot de passe']
                ],
            ])
            ->add('tel',null,[
                'label' => 'Votre numéro de téléphone',
                'attr' => [ 'placeholder' => '06.06.06.06.06']
            ])
            ->add('address',AddressRegisterType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
