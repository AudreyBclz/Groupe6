<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civUser',NULL,array(
                'label_attr'=>['class'=>'text-white'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your Civility'
                    ])]
            ))
            ->add('firstNameUser',NULL,array(
                'label_attr'=>['class'=>'text-white'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your first name'
                    ])]
            ))
            ->add('lastNameUser',NULL,array(
                'label_attr'=>['class'=>'text-white'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your last name'
                    ])]
            ))
            ->add('password', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label_attr'=>['class'=>'text-white'],
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Regex([
                        'pattern'=>"/[A-Z]/",
                        'match'=>true,
                        'message'=>'Your password must contain at least one uppercase.'

                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('telUser',NULL,array(
                'label_attr'=>['class'=>'text-white']
            ))
            ->add('address',AddressType::class)
            ->add('submit',SubmitType::class,array(
                'label'=>'Update',
                'attr'=>['class'=>'btn btn-black']
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr'=>array(
                'class'=>'form'
            )
        ]);
    }
}
