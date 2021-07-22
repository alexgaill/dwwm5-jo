<?php

namespace App\Form;

use App\Entity\Athlete;
use App\Entity\Discipline;
use App\Entity\Pays;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AthleteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('dateNaissance', DateType::class)
            ->add('photo', FileType::class)
            ->add('discipline', EntityType::class, [
                'class' => Discipline::class,
                'choice_label' => "nom"
            ])
            ->add('pays', EntityType::class, [
                'class' => Pays::class,
                'choice_label' => "nom"
            ])
            ->add("Ajouter", SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Athlete::class,
        ]);
    }
}
