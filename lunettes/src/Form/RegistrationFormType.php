<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civUser',NULL,array(
                'constraints'=>new NotBlank([
                    'message'=>'This cannot be empty'
                ])
            ))
            ->add('firstNameUser',NULL,array(
                'constraints'=>new NotBlank([
                    'message'=>'First Name cannot be empty'
                ])
            ))
            ->add('lastNameUser',NULL,array(
                'constraints'=>new NotBlank([
                    'message'=>'Last Name cannot be empty'
                ])
            ))
            ->add('telUser',NULL,array(
                'constraints'=>new NotBlank([
                    'message'=>'Telephone cannot be empty'
                ])
            ))
            ->add('email',NULL,array(
                'constraints'=>new NotBlank([
                    'message'=>'Email cannot be empty'
                ])
            ))
            ->add('address',AddressType::class,array())
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
