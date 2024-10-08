<?php

namespace App\Form;

use App\Entity\AllHabitats;
use App\Entity\Animal;
use App\Entity\Races;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifAnimalDeleteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameToDelete', TextType::class, [
                "label" => "nom de l'animal à supprimer: ",
                "required" => true,
                "attr" => [
                    "class" => "form-champ",
                    'pattern' => '^[a-zA-Z0-9_ -]{3,150}$', // HTML5 pattern attribute for client-side validation
                    'title' => "Le nom doit être composé uniquement de chaine de charactère, de chiffres et de certaines caractère spécial ( _ -)",
                    "placeholder" => "Nom à supprimer"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
