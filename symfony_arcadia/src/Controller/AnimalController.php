<?php

namespace App\Controller;

use App\Entity\AllHabitats;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Animal;
use App\Entity\Races;

class AnimalController extends AbstractController
{
   #[Route("/habitats/{id_habitat}", name: 'app_animal')]
   public function index(ManagerRegistry $mr, int $id_habitat): Response
   {
      $habitat = $mr->getRepository(AllHabitats::class)->findBy(["id"=>$id_habitat]);
      $races = $mr->getRepository(Races::class)->findAll();
      $allAnimauxHabitat = $mr->getRepository(Animal::class)->findBy(["Habitats" => $id_habitat]);
      return $this->render('animalsHabitat/index.html.twig', [
         "habitat" => $habitat,
         "animalHabitat" => $allAnimauxHabitat,
         "races" => $races,
      ]);
   }
}
