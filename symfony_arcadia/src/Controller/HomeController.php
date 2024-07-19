<?php

namespace App\Controller;

use App\Repository\AvisRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    private AvisRepository $AvisRepository;

   public function __construct(AvisRepository $AvisRepository)
    {
      $this->AvisRepository = $AvisRepository;
    }

    #[Route('/', name: 'app_home')]
    public function index(Security $security): Response
    {
        $avis = $this->AvisRepository->findBy(["isValid"=> true]);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'avis' => $avis
        ]);
    }
}
