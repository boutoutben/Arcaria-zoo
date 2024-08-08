<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifScheduleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jour', TextType::class, [
                "label" => "jour: ",
                "required" => true, 
                "attr" => [
                    "class" => "form-champ"
                ]
            ])
            ->add("am", TextType::class, [
                "label" => "Heure du matin: ",
                "required" => true,
                "attr" => [
                    "class" => "form-champ"
                ]
            ])
            ->add("pm", TextType::class, [
                "label" => "Heure de l'après-midi: ",
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
