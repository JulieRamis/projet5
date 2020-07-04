<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
// use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class BookingType extends AbstractType
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
            ->add('title')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
