<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\AllHabitats;
use Doctrine\Persistence\ManagerRegistry;

class AllHabitatsController extends AbstractController
{
    #[Route('/habitats', name: 'app_habitats')]
    public function index(ManagerRegistry $mr): Response
    {
        $allHabitats = $mr->getRepository(AllHabitats::class)->findAll();
        return $this->render('Allhabitats/index.html.twig', [
            'allHabitats' => $allHabitats,
        ]);
    }
}
