<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('homeTeam', TextType::class, ['label' => 'Equipe 1'])
            ->add('awayTeam', TextType::class, ['label' => 'Equipe 2'])
            ->add('dateTime', DateType::class, ['label' => 'Date'], null, [
                'widget' => 'single_text'
            ])
            ->add('price', TextType::class, ['label' => 'Prix'])
            ->add('stadium', TextType::class, ['label' => 'Stade'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
