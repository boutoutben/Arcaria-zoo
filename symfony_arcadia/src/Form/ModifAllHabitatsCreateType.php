<?php

namespace App\Form;

use App\Entity\AllHabitats;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifAllHabitatsCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TypeTextType::class,[
                'label'=>"name: ",
                "required"=> true,
                'attr' => [
                    'class' => "form-champ",
                    ]])
            ->add('description',TextareaType::class,[
                'label'=>"description: ",
                "required"=>true,
                'attr' => [
                    'class' => "form-champ",
                    ]])
            ->add("image",FileType::class, [
                'label'=> "image: ",
                "required"=> true,
                "attr"=> [
                    "class"=> "imageAllHabitats"
                ]
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
