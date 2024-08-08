<?php

namespace App\Controller;

use App\Entity\MessageZoo;
use App\Form\MessageZooType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email as MimeEmail;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;

class MessageZooController extends AbstractController
{
    private RouterInterface $router;

    public function __construct(RouterInterface $router) {
        $this->router = $router;
    }
    #[Route('/message_zoo', name: 'app_message_zoo')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $connection = new MessageZoo();
        $form = $this->createForm(MessageZooType::class, null,[
            "method" => "post",
            "action" => $this->generateUrl("app_send_message")
    ]);
        $form-> handlerequest($request);
        if ($form->isSubmitted() && $form->isValid) {
                $em->persist($connection);
                $em->flush();
        }
        return $this->render('message_zoo/index.html.twig', [
            "form" => $form
        ]);
    }

    #[Route("/send_message", name: "app_send_message")]
    public function send(Request $request, EntityManagerInterface $em, MailerInterface $mailer): Response 
    {
        $emailUser = $request->request->get("emailUser");
        $title = $request->request->get("title");
        $message = $request->request->get("message");
        if($emailUser != "" && $message != " ")
        {
            $email = (new Email())
                ->from($emailUser)
                ->to("arcadio.zoo@gmail.com")
                ->subject($title)
                ->text($message);

            $mailer->send($email);
            return new RedirectResponse(
                $this->router->generate('app_home')
            );
        }
        else{
             return $this->render("bundles/TwigBundle/Exception/failMail.html.twig");
        }
            
    }

}
