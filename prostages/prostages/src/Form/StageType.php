<?php

namespace App\Form;

use App\Entity\Stage;
use App\Entity\Formation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('intitule')
            ->add('description')
            ->add('duree')
            ->add('competencesRequises')
            ->add('experienceRequise')
            ->add('Formation', EntityType::class,
                    [
                      'class'=>Formation::class,
                      'choice_label' => 'intitule',
                      'multiple' => true,
                      'expanded' => true
                    ])
            ->add('entreprise', EntrepriseType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
