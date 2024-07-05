<?php

namespace App\Controller;

use App\Entity\MessageZoo;
use App\Form\MessageZooType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MessageZooController extends AbstractController
{
    #[Route('/message_zoo', name: 'app_message_zoo')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $connection = new MessageZoo();
        $form = $this->createForm(MessageZooType::class);
        $form-> handlerequest($request);
        if ($form->isSubmitted() && $form->isValid) {
                $em->persist($connection);
                $em->flush();
        }
        return $this->render('message_zoo/index.html.twig', [
            "form" => $form
        ]);
    }
}
