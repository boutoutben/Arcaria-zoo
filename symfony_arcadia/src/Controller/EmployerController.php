<?php

namespace App\Controller;

use App\Form\NourrirAnimalType;
use App\Repository\AnimalRepository;
use App\Repository\AvisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;

class EmployerController extends AbstractController
{
    private AvisRepository $AvisRepository;
    private AnimalRepository $AnimalRepository;
    private RouterInterface $router;

    public function __construct(AvisRepository $AvisRepository, AnimalRepository $AnimalRepository, RouterInterface $router)
    {
        $this->AvisRepository = $AvisRepository;
        $this->AnimalRepository = $AnimalRepository;
        $this->router = $router;
    }

    #[Route('/employee', name: 'app_employee')]
    public function index(Request $request): Response
    {
        $avisToValid = $this->AvisRepository->findBy(["isValid"=> false]);
        $animalSelect = $request->request->get("animal")?? -1;
        $animaux = $this->AnimalRepository->findAll();
        $nourritureForm = $this->createForm(NourrirAnimalType::class, null,[
            "method" => "post",
            "action" => $this->generateUrl("app_nourrirAnimal",['id'=> $animalSelect]),
        ]);
        return $this->render('employer/index.html.twig', [
            'controller_name' => 'EmployerController',
            "avisToValid" => $avisToValid,
            "animaux" => $animaux,
            "animalSelect" => $animalSelect,
            "nourritureForm" => $nourritureForm,
        ]);
    }

    #[Route("nourrirAnimal/{id}", name: "app_nourrirAnimal")]
    public function nourrir($id, Request $request,EntityManagerInterface $em): Response
    {
        $date = $request->request->get("date");
        $dataConvert = $date = new \DateTime($date);
        $nourriture = $request->request->get("nourriture");
        $quantitee = $request->request->get("quantitee");
        $animal = $this->AnimalRepository->findOneBy(["id"=>$id]);


        if(isset($date) && isset($nourriture) && isset($quantitee) && $date != "" && $nourriture != "" && $quantitee != "")
        {
            $animal->setDate($dataConvert);
            $animal->setNourriture($nourriture);
            $animal->setQuantitee($quantitee);


            $em->flush();

            return new RedirectResponse(
                $this->router->generate("app_home")
            );
        }
        else
        {
            dd($dataConvert);
            return new RedirectResponse(
                $this->router->generate("app_employee")
            );
        }
    }
}
