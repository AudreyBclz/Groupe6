<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('credit_card',RadioType::class,array(
                'label'=>'Credit Card',
                'value'=>'1',
                'attr'=>['name'=>'payment','class'=>' ml-4 mt-4']))
            ->add('Number_card',NULL,array(
                'label'=>'Card number :',
                'label_attr'=>['class'=>'inline-block w-32'],
                'attr'=>['class'=>'w-1/2 ml-4']
            ))
            ->add('CVV',NULL,array(
                'label'=>'CVV :',
                'label_attr'=>['class'=>'inline-block w-32'],
                'attr'=>['lenght'=>3,'class'=>'w-1/2 ml-4 mt-4 mb-4' ]
            ))
    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
