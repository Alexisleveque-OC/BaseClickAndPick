<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Meal;
use App\Entity\SellTo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MealType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'label' => 'nom du plat'
            ])
            ->add('price', null ,[
                'label' => "prix du plat"
            ])
            ->add('category',EntityType::class,[
                'label' => false,
                'class' => Category::class,
                'choice_label' => 'name'
            ])
            ->add('sellTo',EntityType::class,[
                'label' => 'Vendu à/au',
                'class' => SellTo::class,
                'choice_label' => 'value'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Meal::class,
        ]);
    }
}
