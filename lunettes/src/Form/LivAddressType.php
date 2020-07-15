<?php

namespace App\Form;

use App\Entity\LivAddress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstNameLiv')
            ->add('lastNameLiv')
            ->add('firstAdLiv')
            ->add('secondAdLiv')
            ->add('zipcodeLiv')
            ->add('townLiv')
            ->add('countryLiv')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LivAddress::class,
        ]);
    }
}
