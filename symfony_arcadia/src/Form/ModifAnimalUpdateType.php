<?php

namespace App\Form;

use App\Entity\AllHabitats;
use App\Entity\Animal;
use App\Entity\Races;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifAnimalUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add("nameToChange", TextType::class, [
            "label" => "name de l'animal à changer: ",
            "required" => true, 
            "attr" => [
                "class" => "form-champ"
            ]
        ])
        ->add('name', TextType::class, [
            'label' => 'name: ',
            'required' => false,
            "attr" => [
                "class" => "form-champ"
            ]
        ])
        ->add('etat', TextType::class, [
            'label' => 'etat',
            "required" => false,
            "attr" => [
                "class" => "form-champ"
            ]
        ])

        ->add("raceToChange", TextType::class, [
            "label" => "nom de la race à modifier",
            "required" => false,
            "attr" => [
                "class" => "form-champ"
            ]
        ])

        ->add("race", TextType::class, [
            "label" => "race",
            "required" => false,
            "attr" => [
                "class" => "form-champ"
            ]
        ])

        ->add("img", FileType::class, [
            "required" => false
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
