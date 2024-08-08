<?php

namespace App\Controller;

use App\Repository\AvisRepository;
use App\Repository\ScheduleRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    private AvisRepository $AvisRepository;
    private ScheduleRepository $ScheduleRepository;

   public function __construct(AvisRepository $AvisRepository, ScheduleRepository $scheduleRepository)
    {
      $this->AvisRepository = $AvisRepository;
      $this->ScheduleRepository = $scheduleRepository;
    }

    #[Route('/', name: 'app_home')]
    public function index(Security $security): Response
    {
        $schedule = $this->ScheduleRepository->findAll();
        $avis = $this->AvisRepository->findBy(["isValid"=> true]);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'avis' => $avis,
            "schedule" => $schedule,
        ]);
    }
}
