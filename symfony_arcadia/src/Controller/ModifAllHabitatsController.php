<?php

namespace App\Controller;

use App\Entity\AllHabitats;
use App\Form\ModifAllHabitatsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ModifAllHabitatsController extends AbstractController
{
   

    #[Route('/modifAllHabitats', name: 'app_modif_all_habitats')]
    public function index(): Response
    {
        $habitats = null;
        $form = $this->createForm(ModifAllHabitatsType::class,$habitats,[
            "method"=>"POST",
        ]);
        return $this->render('modif_all_habitats/index.html.twig', [
            'controller_name' => 'ModifAllHabitatsController',
            "form" => $form
        ]);
    }
}
