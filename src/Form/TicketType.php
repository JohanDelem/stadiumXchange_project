<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('homeTeam', TextType::class, ['label' => 'Equipe 1'])
            ->add('awayTeam', TextType::class, ['label' => 'Equipe 2'])
            ->add('dateTime', DateTimeType::class, ['label' => 'Date'], null, [
                'widget' => 'single_text'
            ])
            ->add('price', TextType::class, ['label' => 'Prix'])
            ->add('stadium', TextType::class, ['label' => 'Stade'])
            ->add('competition', ChoiceType::class, [
                'label' => 'Compétition',
                'choices' => [
                    'Ligue 1' => 'Ligue 1',
                    'Ligue des Champions' => 'Ligue des Champions',
                    'Europa League' => 'Europa League',
                    'Coupe de France' => 'Coupe de France',
                    'Ligue des Nations' => 'Ligue des Nations'
                    // Ajoutez d'autres compétitions si nécessaire
                ],
                'placeholder' => 'Sélectionnez une compétition',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
