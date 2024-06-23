<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;


class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('password', PasswordType::class, [
                'label' => 'password ',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le password ne peut pas être vide.',
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 1000,
                        'minMessage' => 'Le password doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le contenu doit contenir au maximum {{ limit }} caractères.',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9!@#$%^&*]{5,1000}$/',
                        'message' => 'Le password  est invalide, .',
                        'match' => true,
                    ]),
                ],
            ])


            ->add('email', EmailType::class, [
                'label' => 'email ',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le email ne peut pas être vide.',
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 10000,
                        'minMessage' => 'Le email doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le email doit contenir au maximum {{ limit }} caractères.',
                    ]),
                    new Regex([
                        'pattern' => '/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
                        'message' => 'L\'email est invalide. ',
                        'match' => true,
                    ]),
                ],
            ])




            /*            ->add('dateCreationUtilisateur', DateTimeType::class,['input' => 'datetime_immutable',])*/
//            ->add('role')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}

