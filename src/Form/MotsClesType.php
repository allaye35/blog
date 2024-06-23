<?php

namespace App\Form;

use App\Entity\MotsCles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class MotsClesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mot',
                TextareaType::class, [
                    'label' => 'mot ',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Le mot ne peut pas être vide.',
                        ]),
                        new Length([
                            'min' => 1,
                            'max' => 1000000,
                            'minMessage' => 'Le contenu doit contenir au moins {{ limit }} caractères.',
                            'maxMessage' => 'Le contenu doit contenir au maximum {{ limit }} caractères.',
                        ]),
                        new Regex([
                            'pattern' => '/^.*$/s',
                            'message' => 'Le contenu Markdown est invalide.',
                            'match' => true,
                        ]),
                    ],
                ])

            ->add('articles')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MotsCles::class,
        ]);
    }
}
