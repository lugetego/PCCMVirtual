<?php

namespace App\Form;

use App\Entity\Registro;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class RegistroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('apellidos')
            ->add('nacionalidad')
            ->add('correo')
            ->add('residencia')
            ->add('estudiante', ChoiceType::class, [
                'choices'  => [
                    'Seleccionar' => null,
                    'Si' => true,
                    'No' => false,
                ],
            ])
            ->add('grado', ChoiceType::class, [
                'choices'  => [
                    'Seleccionar' => null,
                    'Doctorado' => 'Doctorado',
                    'Maestría' => 'Maestría',
                    'Licenciatura' => 'Licenciatura',
                    'Especialidad'=>'Especialidad',
                ],
            ])
            
            ->add('programa')
            ->add('institucion')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Registro::class,
        ]);
    }
}
