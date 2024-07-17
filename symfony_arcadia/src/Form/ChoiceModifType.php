<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChoiceModifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('choice', ChoiceType::class, array(
                'choices' => array(
                    'créer' => "create",
                    'mettre à jour' => "update",
                    'supprimer' => "delete",
                ),
                'choice_attr' => [
                    'créer' => ['data' => 'create'],
                    'mettre à jour' => ['data' => 'update'],
                    'supprimer' => ['data' => 'delete'],
                ],
            ));
                
                
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
