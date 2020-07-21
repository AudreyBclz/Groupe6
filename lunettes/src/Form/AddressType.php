<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstAddress',NULL,array(
                'constraints'=>new NotBlank([
                    'message'=>'Address cannot be empty'
                ])
            ))
            ->add('secondAddress')
            ->add('zipcodeAddress',NULL,array(
                'constraints'=>new NotBlank([
                    'message'=>'ZipCode cannot be empty'
                ])
            ))
            ->add('townAddress',NULL,array(
                'constraints'=>new NotBlank([
                    'message'=>'Town cannot be empty'
                ])
            ))
            ->add('countryAddress',NULL,array(
                'constraints'=>new NotBlank([
                    'message'=>'Country cannot be empty'
                ])
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
            'attr'=>array(
                'class'=>'form'
            )
        ]);
    }
}
