<?php

namespace App\Controller;

use App\Entity\AllHabitats;
use App\Entity\RapportVeterinaire;
use App\Form\CommentaireHabitatType;
use App\Form\RapportVererinaireType;
use App\Repository\AllHabitatsRepository;
use App\Repository\AnimalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;

class VeterinaireController extends AbstractController
{
    private AnimalRepository $AnimalRepository;
    private AllHabitatsRepository $allHabitatsRepository;
    private RouterInterface $router;

    public function __construct(AnimalRepository $AnimalRepository, RouterInterface $router, AllHabitatsRepository $allHabitatsRepository)
    {
        $this->AnimalRepository = $AnimalRepository;
        $this->allHabitatsRepository = $allHabitatsRepository;
        $this->router = $router;
    }

    #[Route('/veterinaire', name: 'app_veterinaire')]
    public function index(): Response
    {
        $veterinaireForm = $this->createForm(RapportVererinaireType::class, null,[
            "method" => "post",
            "action" => $this->generateUrl("app_rapport"),
        ]);

        $commentaireForm = $this->createForm(CommentaireHabitatType::class, null, [
            "method" => "post",
            "action" => $this->generateUrl("app_commentaire"),
        ]);
        $Allanimaux = $this->AnimalRepository->findAll();
        return $this->render('veterinaire/index.html.twig', [
            'controller_name' => 'VeterinaireController',
            "veterinaireForm" => $veterinaireForm,
            "commentaireForm" => $commentaireForm,
            "allAnimaux" => $Allanimaux,
        ]);
    }

    #[Route("/rapport", name:"app_rapport")]
    public function rapport(Request $request,EntityManagerInterface $em) : Response 
    {
        $name = $request->request->get("name");
        $rapport = $request->request->get('rapport');

        if(isset($rapport) && $rapport != "" && isset($name) && $name != "")
        {
            $animal = $this->AnimalRepository->findOneBy(["name"=>$name]);
            if($animal != null)
            {
                $rapport_veteriniaire = new RapportVeterinaire();
                $rapport_veteriniaire->setDetail($rapport);
                
                $rapport_veteriniaire->setAnimal($animal);

                $em->persist($rapport_veteriniaire);

                $animal->setLastRapport($rapport_veteriniaire);

                $em->flush();

                return new RedirectResponse(
                    $this->router->generate("app_home")
                );
            }
            else{
                return $this->render("bundles/TwigBundle/Exception/NotFoundName.html.twig");
            }
            
        }
    }

    #[Route("/commentaire", name: "app_commentaire")]
    public function commentaire(Request $request, EntityManagerInterface $em):Response
    {
        $nameHabitat = $request->request->get("nameHabitat");
        $commentaire = $request->request->get("commentaire");

        if(isset($nameHabitat) && $nameHabitat != "" && isset($commentaire) && $commentaire != "")
        {
            $habitat = $this->allHabitatsRepository->findOneBy(["name"=> $nameHabitat]);
            if($habitat != null)
            {
                $habitat->setCommentaire($commentaire);
                $em->flush();

                return new RedirectResponse(
                    $this->router->generate("app_home")
                );
            }
            else{
                return $this->render("bundles/TwigBundle/Exception/NotFoundName.html.twig");
            }  
        }
        return new RedirectResponse(
            $this->router->generate("app_veterinaire")
        );
        
    }
}
