<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Establishment;
use App\Entity\Suite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $a = date('Y', strtotime('+3years'));


        $builder
            ->add('establishment', EntityType::class, [
                'class' => Establishment::class,
                'choice_label' => 'nom',
                'data_class' => null,
                'empty_data' => '',
            ])
            ->add('suite', EntityType::class, [
                'class' => Suite::class,
                'choice_label' => 'titre',
                'data_class' => null,
                'empty_data' => '',
            ])
            ->add('date_debut', DateType::class, [
                'years' => range(date('Y'), date('Y', strtotime('+3years'))),
                'months' => range(date('m'), 12),
                'days' => range(date('d'), 31),
            ])
            ->add('date_fin', DateType::class, [
                'years' => range(date('Y'), date('Y', strtotime('+3years'))),
                'months' => range(date('m'), 12),
                'days' => range(date('d', strtotime('+1day')), 31),
            ])
            ->add('check_availability', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
