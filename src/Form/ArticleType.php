<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\MotsCles;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\RegexValidator;




class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'titre en Markdown',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le titre ne peut pas être vide.',
                    ]),


                ],
            ])

            ->add('contenu', TextareaType::class, [
                'label' => 'Contenu en Markdown',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le contenu ne peut pas être vide.',
                    ]),
                    new Length([
                        'min' => 10,
                        'max' => 100000,
                        'minMessage' => 'Le contenu doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le contenu doit contenir au maximum {{ limit }} caractères.',
                    ]),
                    new Regex([
                        'pattern' => '/^.*$/s',
                        'message' => 'Le contenu Markdown est invalide.',
                        'match' => true,
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9\s\*\-\_\`\#\!\[\]\(\)\<\>\.\,]*$/s', // Expression régulière pour vérifier la syntaxe Markdown
                        'message' => 'Le contenu doit être au format Markdown.',
                        'match' => true,
                    ]),
                ],
            ])
            ->add('motsCles', EntityType::class, [
                'class' => MotsCles::class,
                'choice_label' => 'mot',
                'multiple' => true,
                'expanded' => false,
                'label' => 'Mots Clés',
            ])
            ->add('nouveauMotCle', TextType::class, [
                'label' => 'Ajouter un nouveau mot clé',
                'required' => false,
                'mapped' => false, // Ne pas mapper ce champ à l'entité
            ])

//        ->add('dateCreation', DateTimeType::class, [
//            'label' => 'Date de création',
//            'data' => new \DateTime(),
//            'html5' => false,
//            'attr' => [
//                'class' => 'datepicker',
//            ],
//            'constraints' => [
//                new NotBlank([
//                    'message' => 'La Date de création ne peut pas être vide.',
//                ]),
//
//            ],
//        ])

//             ->add('titre')
//            ->add('contenu')
//            ->add('dateCreation')
//            ->add('utilisateur')
//            ->add('motsCles',TextareaType::class, [
//                'label' => 'Mots clés',
//                'required' => false,
//                'mapped' => false,
//                // Autres options éventuelles pour le champ...
//            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
