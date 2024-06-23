<?php

namespace App\Form;

use App\Entity\Role;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description',
                TextareaType::class, [
                    'label' => 'description ',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Le description ne peut pas être vide.',
                        ]),
                        new Length([
                            'min' => 1,
                            'max' => 1000000,
                            'minMessage' => 'Le contenu doit contenir au moins {{ limit }} caractères.',
                            'maxMessage' => 'Le contenu doit contenir au maximum {{ limit }} caractères.',
                        ]),
                        new Regex([
                            'pattern' => '/^.*$/s',
                            'message' => 'Le description  est invalide.',
                            'match' => true,
                        ]),
                    ],
                ])



        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Role::class,
        ]);
    }
}
