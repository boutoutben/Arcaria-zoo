<?php

namespace App\Form;

use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterAvisAdministrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameAnimal', TextType::class, [
                "label"=> "nom de l'animal: ",
                "required" => false,
                "attr" => [
                    "class" => "form-champ"
                ]
            ])
            ->add("date", DateType::class, [
                "label" => "date: ",
                "required" => false,
                "attr" => [
                    "class" => "form-champ",
                    "placeholder"=> "année-mois-jour"
                ],
                'widget' => 'single_text',
                'html5' => false,
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
