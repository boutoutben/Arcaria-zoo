<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class ConnectionType extends AbstractType
{
    private $csrfToken;
    public function __construct(CsrfTokenManagerInterface $csrfTokenManager)
    {
        $this->csrfToken = $csrfTokenManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class,[
                'label'=>"username: ",
                "required" => true,
                'attr' => [
                    'class' => "form-champ",
                ],
            ])
            ->add('password',PasswordType::class,[
                'attr' => [
                    'class' => "form-champ",
                    'name' => "password"
                ],
                'label' => "mot de passe: ",
                "required" => true
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null, // Allow form data to be an array
        ]);
    }
}
