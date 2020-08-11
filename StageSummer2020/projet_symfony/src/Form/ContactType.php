<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
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
                'attr'=>['placeholder'=>'Nom Prénom','class'=>'w-50 mb-3 p-2'],
            ))
            ->add('email',TextType::class,array(
                'attr'=>['placeholder'=>'Email','class'=>'w-50 mb-3 p-2']
            ))
            ->add('subject',TextType::class,array(
                'attr'=>['placeholder'=>'Sujet','class'=>'w-50 mb-3 p-2']
            ))
            ->add('content',TextareaType::class,array(
                'attr'=>['placeholder'=>'Contenu','class'=>'d-block w-100 p-2']
            ))
            ->add('submit',SubmitType::class,array(
                'label'=>'Envoyer',
                'attr'=>['class'=>'btn bg-violet text-light mt-4']
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
