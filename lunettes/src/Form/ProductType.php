<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Gender;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nameProduct',NULL,array(
                'constraints'=>new NotBlank([
                    'message'=>'Product Name cannot be empty'
                ])
            ))
            ->add('descrProduct',NULL,array(
                'constraints'=>new NotBlank([
                    'message'=>'Description cannot be empty'
                ])
            ))
            ->add('priceProduct',NULL,array(
                'constraints'=>new NotBlank([
                    'message'=>'Price cannot be empty'
                ])
            ))
            ->add('statusProduct')
            ->add('imageFile', FileType::class, array(
                'required' => false
            ))
            ->add('stockProduct',NULL,array(
                'constraints'=>new NotBlank([
                    'message'=>'Stock cannot be empty'
                ])
            ))
            ->add('gender', EntityType::class, array(
                'class' => Gender::class,
                'choice_label' => 'nameGender',
                'multiple' => false,
                'required' => false
            ))
            ->add('category', EntityType::class, array(
                'class' => Category::class,
                'choice_label' => 'nameCategory',
                'multiple' => false,
                'required' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'attr'=>array(
                'class'=>'form'
            )
        ]);
    }
}
