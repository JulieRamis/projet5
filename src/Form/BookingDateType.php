<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingDateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('beginAt', DateType::class, [
                'label' => false,
                'attr' => ['class' => 'datepicker'],
                'widget' => 'single_text',
                'html5' => false
            ])
            ->add('endAt', DateType::class, [
                'label' => false,
                'attr' => ['class' => 'datepicker'],
                'widget' => 'single_text',
                'html5' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        ]);
    }
}
