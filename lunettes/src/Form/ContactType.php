<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName',TextType::class,array(
                'attr'=>['class'=>'field-input display-7 mt-1 mb-3'],

            ))
            ->add('emailContact',EmailType::class,array(
                'attr'=>['class'=>'field-input display-7 mt-1 mb-3']
            ))
            ->add('subject', TextType::class,array(
                'attr'=>['class'=>'field-input display-7 mt-1 mb-3']
            ))
            ->add('content',TextareaType::class,array(
                'attr'=>['class'=>'field-input display-7 mt-1 mb-5']
            ))
            ->add('submit',SubmitType::class,array(
                'label'=>'Send',
                'attr'=>['class'=>'btn btn-black']
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
