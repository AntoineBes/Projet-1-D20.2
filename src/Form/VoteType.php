<?php

namespace App\Form;

use App\Entity\Vote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class VoteType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('note')
                ->add('note', ChoiceType::class, [
                    'choices' => [
                        '★' => 1,
                        '★ ★' => 2,
                        '★ ★ ★' => 3,
                        '★ ★ ★ ★' => 4,
                        '★ ★ ★ ★ ★' => 5,
                    ],
                ])
                ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Vote::class,
        ]);
    }

}
