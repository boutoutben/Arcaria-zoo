<?php

namespace App\Form;

use App\Entity\Avis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CreateAvisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class, [
                'label' => "pseudo: ",
                "required" => true,
                "attr" => [
                    "class" => "form-champ"
                ],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le pseudo ne peut pas être vide.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/[a-zA-Z0-9]{2,255}',
                        'match' => false,
                        'message' => 'Le pseudo ne doit contenir que des lettres et des chiffres.',
                    ]),
                ],
            ])
            ->add('avis', TextareaType::class, [
                "label" => "avis: ",
                "required" => true,
                "attr" => [
                    "class" => "form-champ"
                ],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => "L'avis ne peut pas être vide.",
                    ]),
                    new Assert\Regex([
                        'pattern' => '/[a-zA-Z0-9]{2,255}',
                        'match' => false,
                        'message' => 'Le pseudo ne doit contenir que des lettres et des chiffres.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Avis::class,
        ]);
    }
}
