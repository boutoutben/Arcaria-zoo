<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RapportVererinaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("AnimalName", TextType::class, [
                "label" => "Nom de l'animal: ",
                "required" => true,
                "attr" => [
                    'class' => "form-champ"
                ]
            ])
            ->add('rapport', TextareaType::class, [
                "label" => "rapport: ",
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
