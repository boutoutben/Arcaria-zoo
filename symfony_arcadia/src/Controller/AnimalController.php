<?php

namespace App\Controller;

use App\Entity\AllHabitats;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Animal;
use App\Entity\Races;
use App\Repository\AnimalRepository;
use App\Repository\RacesRepository;

class AnimalController extends AbstractController
{
   private AnimalRepository $AnimalRepository;
   private RacesRepository $RacesRepository;

   public function __construct(AnimalRepository $AnimalRepository, RacesRepository $RacesRepository)
    {
      $this->AnimalRepository = $AnimalRepository;
      $this->RacesRepository = $RacesRepository;
    }


   #[Route("/habitats/{id_habitat}", name: 'app_animal')]
   public function index(ManagerRegistry $mr, int $id_habitat): Response
   {
      $habitat = $mr->getRepository(AllHabitats::class)->findBy(["id"=>$id_habitat]);
      $allAnimauxHabitat = $mr->getRepository(Animal::class)->findBy(["Habitats" => $id_habitat]);
      $races = array();
      foreach($allAnimauxHabitat as $animal)
      {
         array_push($races, $this->RacesRepository->findBy(['id'=> $animal->getRaces()]));
      }

      $animalData = [];
        foreach ($allAnimauxHabitat as $animal) {
         $id = 0;
            $animalData[] = [
                'animal' => $animal,
                'race' => $races[$id] ?? 'Unknown', // Ensure a default value if the race is not found
            ];
         $id +=1;
        }
      $nbAnimal = $this->AnimalRepository->createQueryBuilder('a')
            // Filter by some parameter if you want
            // ->where('a.published = 1')
            ->select('count(a.id)')
            ->Where("a.Habitats = {$id_habitat}")            
            ->getQuery()
            ->getSingleScalarResult();
      return $this->render('animalsHabitat/index.html.twig', [
         "habitat" => $habitat,
         "animalData" => $animalData,
         "nbAnimal" => $nbAnimal
      ]);
   }
}
