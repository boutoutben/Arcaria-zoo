<?php

namespace App\Controller;

use App\Entity\AllHabitats;
use App\Entity\Animal;
use App\Entity\Races;
use App\Form\ChoiceModifType;
use App\Form\ModifAnimalCreateType;
use App\Form\ModifAnimalDeleteType;
use App\Form\ModifAnimalUpdateType;
use App\Repository\AllHabitatsRepository;
use App\Repository\AnimalRepository;
use App\Repository\RacesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;

#[Route('/modifAnimaux', name: 'app_modif_animaux_')]
class ModifAnimauxController extends AbstractController
{
    private AnimalRepository $AnimalRepository;
    private RouterInterface $router;
    private RacesRepository $RacesRepository;
    private AllHabitatsRepository $allHabitatsRepository;

    public function __construct(AnimalRepository $AnimalRepository, RouterInterface $router, RacesRepository $racesRepository, AllHabitatsRepository $allHabitatsRepository)
    {
        $this->AnimalRepository = $AnimalRepository;
        $this->router = $router;
        $this->RacesRepository = $racesRepository;
        $this->allHabitatsRepository = $allHabitatsRepository;
    }

    #[Route('/index/{id_habitat}', name: 'index')]
    public function index($id_habitat, ManagerRegistry $mr): Response
    {
        $animal = null;
        $choice = $_POST["choice"] ?? '';

        $form = $this->createForm(ModifAnimalCreateType::class,$animal,[
            "action" => $this->generateUrl('app_modif_animaux_create', ["id_habitat"=> $id_habitat]),
            "method"=>"POST",
        ]);
        $formUpdate = $this->createForm(ModifAnimalUpdateType:: class, $animal,[
            "action" => $this->generateUrl('app_modif_animaux_update',["id_habitat"=> $id_habitat]),
            "method"=>"POST",
        ]);

        $formDelete = $this->createForm(ModifAnimalDeleteType:: class, $animal,[
            "action" => $this->generateUrl('app_modif_animaux_delete',["id_habitat"=> $id_habitat]),
            "method"=>"POST",
        ]);

        return $this->render('modif_animaux/index.html.twig', [
            "form" => $form,
            "choice" => $choice,
            "formUpdate" => $formUpdate,
            "formDelete" => $formDelete,
            "title" => "modier les habitats",
            "actionName" => "/modifAnimaux/index/{$id_habitat}",
            "namePlace" => "animal"
        ]);
    }


    #[Route('/create/{id_habitat}', name: 'create')]
    public function create(Request $request, EntityManagerInterface $em, $id_habitat):Response
    {
        $animal = new Animal();
        $raceEntity = new Races();
        $name = $request->request->get('name');
        $etat = $request->request->get("etat");
        $race = $request->request->get("race");
        $image = $request->files->get("image");
        $uploadDir = $this->getParameter('upload_directory');
            
            try {
                $image->move($uploadDir, $image->getClientOriginalName());
                // Success logic here
            } catch (FileException $e) {
                // Handle exception if something happens during file upload
            }

        if(isset($name)&& isset($etat)&&isset($race)){
            $animal->setName($name);
            $animal->setEtat($etat);
            $animal->setImg($image->getClientOriginalName());
            if($this->RacesRepository->findOneBy(['label' => $race]) == null)
            {
                $raceEntity->setLabel($race);
                $em->persist($raceEntity);
                $em->flush();
                $raceEntity = $this->RacesRepository->findOneBy(['label' => $race]);
                $animal->setRace($raceEntity);
                $habitat = $this->allHabitatsRepository->findOneBy(["id" => $id_habitat]);
                $animal->setHabitats($habitat);
            }
            else{
                $habitat = $this->allHabitatsRepository->findOneBy(["id" => $id_habitat]);
                $animal->setHabitats($habitat);
                $raceEntity = $this->RacesRepository->findOneBy(['label' => $race]);
                $animal->setRace($raceEntity);
            }
            

            $em->persist($animal);
            $em->flush();

            return new RedirectResponse(
                $this->router->generate('app_home')
            );
        }
    }

    #[Route('/update', name: 'update')]
    public function update(Request $request, EntityManagerInterface $em):Response
    {
        $animal = new Animal();
        $nameToChange = $request->request->get('nameToChange');
        $name = $request->request->get('name');
        $etat = $request->request->get("etat");
        $raceToChange = $request->request->get("raceToChange");
        $race = $request->request->get("race");
        $image = $request->files->get("image");
        $uploadDir = $this->getParameter('upload_directory');

        if(isset($nameToChange)){
            $animal = $this->AnimalRepository->findOneBy(['name' => $nameToChange]);
            if($animal != null)
            {
                if($name != ""){
                    $animal->setName($name);
    
                }
                if($etat != ""){
                    $animal->setEtat($etat);
                }
                if($race != "" && $raceToChange != "")
                {
                    $raceEntity = $this->RacesRepository->findOneBy(['label'=> $raceToChange]);
                    if($race != null)
                    {
                        $raceEntity->setLabel($race);
                    }
                    
                }
                if(isset($image)){
                    try {
                        $image->move($uploadDir, $image->getClientOriginalName());
                        // Success logic here
                    } catch (FileException $e) {
                        // Handle exception if something happens during file upload
                    }
                    $animal->setImg($image->getClientOriginalName());
                }
                    
                    
                $em->flush();
    
                return new RedirectResponse(
                    $this->router->generate('app_home')
                );
            }
            else{
                return $this->render("bundles/TwigBundle/Exception/NotFoundName.html.twig");
            }
        }
           

    }

    #[Route("/delete", name:"delete")]
    public function delete(Request $request, EntityManagerInterface $em)
    {
        $nameToDelete = $request->request->get("nameToDelete");
        $animals = $this->AnimalRepository->findBy(['name'=>$nameToDelete]);
        if($animals !=  null)
        {
            foreach ($animals as $animal) {
                $nbAnimal = $this->AnimalRepository->createQueryBuilder('a')
                ->select('count(a.id)')
                ->Where("a.race = {$animal->getRaces()->getId()}")            
                ->getQuery()
                ->getSingleScalarResult();
                $em->remove($animal);
                
            }
    
            if($nbAnimal == 1)
            {
                $race = $this->RacesRepository->findBy(["label" => $animal->getRaces()->getLabel()]);
                foreach($race as $race)
                {
                    $em->remove($race);
                }
            }
    
            
            $em->flush();
    
            return new RedirectResponse(
                $this->router->generate('app_home')
            );
        }
        else{
            return $this->render("bundles/TwigBundle/Exception/NotFoundName.html.twig");
        }
        
    }
}
