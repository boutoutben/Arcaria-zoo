<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("employer", RadioType::class,[
                'label'=>'employer',
                'row_attr' => ['for' => "choice2"],
                "attr"=>[
                    "value"=> "employer"
                ]

            ])
            ->add("veterinaire",RadioType::class, [
                "label"=>"vetérinaire",
                'row_attr' => ['for' => "choice2"],
                "attr"=>[
                    "value"=> "veterinaire",
                ]
                
            ])
            ->add('username', EmailType::class,[
                "label"=>'username',
                "required"=>true,
                "attr" => [
                    "class" => "form-champ"
                ]
                
            ])
            ->add('password', PasswordType::class, [
                "label" =>"password",
                "required"=>true,
                "attr" => [
                    "class" => "form-champ"
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
