<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdministrationPageController extends AbstractController
{
    #[Route('/administration', name: 'app_administration_page')]
    public function index(): Response
    {
        $info = null;
        $form = $this->createForm(RegisterType::class, $info,[
            "action" => $this->generateUrl('app_register'),
            "method" => 'POST'
        ]);

        return $this->render('administration_page/index.html.twig', [
            "form" => $form
        ]);
    }
}
