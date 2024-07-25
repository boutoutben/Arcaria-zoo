<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentaireHabitatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('habitatName', TextType::class, [
                "label" => "nom de l'habitat: ",
                "required" => true,
                "attr" => [
                    "class" => "form-champ"
                ]
            ])
            ->add("commentaire", TextType::class, [
                "label" => "commentaire: ",
                "required" => true,
                "attr" => [
                    "class" => "form-champ"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
