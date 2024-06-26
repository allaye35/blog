<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Commentaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('commentaire', TextareaType::class, [
                'label' => 'Commentaire',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le commentaire ne peut pas être vide.',
                    ]),
                    new Length([
                        'min' => 2,
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
//            ->add('utilisateur')
            ->add('article', EntityType::class, [
                'class' => Article::class,
                'choice_label' => 'titre',
                'label' => 'Article',
                'attr' => ['class' => 'form-control'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
