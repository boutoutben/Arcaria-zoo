<?php

namespace App\Form;

use App\Entity\MessageZoo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageZooType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('emailUser', EmailType::class,[
                'attr' => [
                    'class' => "form-champ"
                ],
                "label"=> "Votre email: ",
                "required" => true
            ])
            ->add('titleMessage',TextType::class,[
                'attr' => [
                    'class' => "form-champ"
                ],
                "label"=>"titre: ",
                "required" => true
            ])
            ->add('message', TextareaType::class, [
                'attr' => [
                    'class' => "form-textarea"
                ],
                "label"=>"message: ",
                "required"=>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MessageZoo::class,
        ]);
    }
}
