<?php

namespace App\Form;

use App\Entity\LivAddress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class LivAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstNameLiv',NULL,array(
                'label'=>'First Name',
                'row_attr'=>['class'=>'mb-4'],
                'constraints'=>new NotBlank([
                    'message'=>'First Name cannot be empty'
                ])
            ))
            ->add('lastNameLiv',NULL,array(
                'label'=>'Last Name',
                'row_attr'=>['class'=>'mb-4'],
                'constraints'=>new NotBlank([
                    'message'=>'Last Name cannot be empty'
                ])
            ))
            ->add('firstAdLiv',NULL,array(
                'label'=>'Address',
                'row_attr'=>['class'=>'mb-4'],
                'constraints'=>new NotBlank([
                    'message'=>'Address cannot be empty'
                ])
            ))
            ->add('secondAdLiv',NULL,array(
                'label'=>'Additional',
                'row_attr'=>['class'=>'mb-4']
            ))
            ->add('zipcodeLiv',NULL,array(
                'label'=>'Zip Code',
                'row_attr'=>['class'=>'mb-4'],
                'constraints'=>new NotBlank([
                    'message'=>'ZipCode cannot be empty'
                ])
            ))
            ->add('townLiv',NULL,array(
                'label'=>'Town',
                'row_attr'=>['class'=>'mb-4'],
                'constraints'=>new NotBlank([
                    'message'=>'Town cannot be empty'
                ])
            ))
            ->add('countryLiv',NULL,array(
                'label'=>'Country',
                'row_attr'=>['class'=>'mb-4'],
                'constraints'=>new NotBlank([
                    'message'=>'Country cannot be empty'
                ])
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LivAddress::class,
            'attr'=>array(
                'class'=>'form'
            )
        ]);
    }
}
