<?php

namespace App\Form;

use App\Entity\Age;
use App\Entity\Event;
use App\Entity\Genre;
use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('price')
            ->add('description')
            ->add('picture')
            ->add('shoppingLink')
            ->add('ageRange', EntityType::class, [
                // @link https://symfony.com/doc/current/reference/forms/types/entity.html#basic-usage
                'class' => Age::class,               
                'choice_label' => 'label',
                'multiple' => true,
                'expanded' => true,                
                ])    
            ->add('gender', EntityType::class, [
                // @link https://symfony.com/doc/current/reference/forms/types/entity.html#basic-usage
                'class' => Genre::class,               
                'choice_label' => 'label',
                'expanded' => true,                
                ])
            ->add('status')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('category', EntityType::class, [
                // @link https://symfony.com/doc/current/reference/forms/types/entity.html#basic-usage
                'class' => Category::class,               
                'choice_label' => 'label',
                'multiple' => true,
                'expanded' => true,                
                ])
            ->add('events', EntityType::class, [
                // @link https://symfony.com/doc/current/reference/forms/types/entity.html#basic-usage
                'class' => Event::class,               
                'choice_label' => 'label',
                'multiple' => true,
                'expanded' => true,                
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
