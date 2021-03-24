<?php

namespace App\Form;

use App\Entity\Quote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuoteType extends AbstractType
{

    const PRIORITY_NONE = 'none';
    const PRIORITY_IMPORTANT = 'important';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->add('position', ChoiceType::class, [
                'choices' => [
                    'Important' => self::PRIORITY_IMPORTANT,
                    'None' => self::PRIORITY_NONE
                ],
                'attr' => ['class' => 'mt-4']
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Create Quote',
                'attr' => ['class' => 'btn btn-primary mt-4']
            ]);
        }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quote::class,
        ]);
    }
}
