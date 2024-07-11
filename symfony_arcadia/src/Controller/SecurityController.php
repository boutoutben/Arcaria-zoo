<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ConnectionType;
use App\Form\LoginFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use SebastianBergmann\Environment\Console;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Validator\Constraints\Choice;

class SecurityController extends AbstractController
{
    private UserRepository $userRepository;
    private RouterInterface $router;

    public function __construct(UserRepository $userRepository, RouterInterface $router)
    {
        $this->userRepository = $userRepository;
        $this->router = $router;
    }

    #[Route("/register", name:"app_register")]
    public function register(Request $request,EntityManagerInterface $em,UserPasswordHasherInterface $passwordHasher)
    {
        $choice = $request->request->get('choix');
        $username = $request->request->get("username");
        $password = $request->request->get("password");

        if(isset($choice) && isset($username)&&isset($password)){
            $user = new User();
            $user->setUsername($username);
            $user->setPassword($passwordHasher->hashPassword($user, $password));
            if($choice == "employer"){
                $user->setRoles(["ROLE_EMPLOYER"]);
            }
            else{
                $user->setRoles(["ROLE_VETERINAIRE"]);
            }

            $em->persist($user);
            $em->flush();
            return new RedirectResponse(
                $this->router->generate('app_home')
            );
        }
        else{
            dd("Une erreur s'est produit");
        }
    }



    #[Route("/login", name:"app_login")]
    
    public function login(Request $request, AuthenticationUtils $authenticationUtils, SessionInterface $session): Response
    {
        // Get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // Last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // Retrieve form data from session if it exists

        // Create the login form
        $form = $this->createForm(ConnectionType::class, [
            'method' => 'POST',
        ]);

        // Clear the form data from session after retrieving it

        return $this->render('security/index.html.twig', [
            'form' => $form->createView(),
            'error' => $error,
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(Security $security): void
    {
        $response = $security->logout(false);
    }
}