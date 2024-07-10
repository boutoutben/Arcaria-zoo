<?php

namespace App\Controller;

use App\Form\ConnectionType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class ConnectionController extends AbstractController
{
    #[Route('/connection', name: 'app_connection')]
    public function index(Request $request,EntityManagerInterface  $em): Response
    {
       
        $connection = new User();
        $form = $this->createForm(ConnectionType::class, $connection,[
            'action' => $this->generateUrl('app_connection'),
            'method' => 'POST',
        ]);
        $form-> handlerequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($connection);
                $em->flush();
        }
        return$this->render('connection/index.html.twig', [
            'form' => $form
        ]);
        
    }

}
