<?php

namespace App\Form;

use App\Entity\Conference;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ConferenceType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title')
                ->add('description')
                ->add('adresse')
                ->add('date', DateTimeType::class, [
                    'format' => 'yyyy-MM-dd HH:mm',
                    'widget' => 'single_text',                    
                    'html5' => false,                    
                    'attr' => ['class' => 'js-datepicker'],
                ])
                ->add('intervenant')
                ->add('sous_titre')
                ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Conference::class,
        ]);
    }

}
