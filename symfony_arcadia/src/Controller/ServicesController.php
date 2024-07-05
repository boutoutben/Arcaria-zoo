<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Services;
use Doctrine\Persistence\ManagerRegistry;

class ServicesController extends AbstractController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route('/services', name: 'app_services')]
    public function index(ManagerRegistry $mr): Response
    {
        $allServices = $mr->getRepository(Services::class)->findAll();
        return $this->render('services/index.html.twig', [
            'allServices' => $allServices
        ]);
    }
}
