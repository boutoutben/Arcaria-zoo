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
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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
    public function register(Request $request,EntityManagerInterface $em,UserPasswordHasherInterface $passwordHasher,MailerInterface $mailer)
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

            $email = (new Email())
                ->from('jose.direction@gmail.com')
                ->to($username)
                ->subject("Information pour votre espace attitrer")
                ->text("Votre username est ".$username. ". Pour votre mot de passe merci de me rencontrer pour une question de sécurité");

            $mailer->send($email);
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
    $formData = $session->get('formData', []);

    // Create the login form with method 'POST'
    $form = $this->createForm(ConnectionType::class, null, [
        'method' => 'POST',
        'data' => $formData, // Optionally set data if needed
    ]);

    // Clear the form data from session after retrieving it
    $session->remove('formData');

    // Render the login form and pass the necessary variables
    return $this->render('security/index.html.twig', [
        'form' => $form->createView(), // Ensure you're passing the form view to the template
        'error' => $error,
        'last_username' => $lastUsername,
    ]);
}

    #[Route('/loginError', name:"app_login_error")]
    public function loginError():Response
    {
        return $this->render("bundles/TwigBundle/Exception/failLogin.html.twig");
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(Security $security): void
    {
        $response = $security->logout(false);
    }
}