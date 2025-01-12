<?php

namespace App\Form;

use App\Entity\Classroom;
use App\Entity\Student;
use App\Entity\Club;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nsc')
            ->add('email')
            ->add('class', EntityType::class, [
                // looks for choices from this entity
                'class' => Classroom::class,
                // uses the User.username property as the visible option string
                'choice_label' => 'name',
                // used to render a select box, check boxes or radios
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('clubs', EntityType::class, [
                // looks for choices from this entity
                'class' => Club::class,
                // uses the User.username property as the visible option string
                'choice_label' => 'ref',
                // used to render a select box, check boxes or radios
                'multiple' => true,
                'expanded' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
