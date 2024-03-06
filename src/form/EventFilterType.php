<?php
// src/Form/EventFilterType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class EventFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('eventName', ChoiceType::class, [
                'choices'  => [
                    'Frontend Masters' => 'Frontend Masters',
                    'Backend Masters' => 'Backend Masters',
                    'Truth about PHP' => 'Truth about PHP',
                    // Ajoutez plus d'événements ici
                ],
            ])
        ;
    }
}
?>