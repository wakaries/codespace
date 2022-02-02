<?php

namespace App\Form;

use App\Entity\Entrada;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntradaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('slug')
            ->add('titulo')
            ->add('fecha', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('estado', ChoiceType::class, [
                'choices' => [
                    'Activa' => 1,
                    'Inactiva' => 0
                ]
            ])
            ->add('resumen')
            ->add('texto')
            ->add('categoria')
            ->add('etiquetas', null, [
                'expanded' => true
            ])
            ->add('usuario')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entrada::class,
        ]);
    }
}
