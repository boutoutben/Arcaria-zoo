<?php

namespace App\Controller;

use App\Entity\RapportVeterinaire;
use App\Form\RapportVererinaireType;
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
    private RouterInterface $router;

    public function __construct(AnimalRepository $AnimalRepository, RouterInterface $router)
    {
        $this->AnimalRepository = $AnimalRepository;
        $this->router = $router;
    }

    #[Route('/veterinaire', name: 'app_veterinaire')]
    public function index(): Response
    {
        $veterinaireForm = $this->createForm(RapportVererinaireType::class, null,[
            "method" => "post",
            "action" => $this->generateUrl("app_rapport"),
        ]);
        return $this->render('veterinaire/index.html.twig', [
            'controller_name' => 'VeterinaireController',
            "veterinaireForm" => $veterinaireForm,
        ]);
    }

    #[Route("/rapport", name:"app_rapport")]
    public function rapport(Request $request,EntityManagerInterface $em) : Response 
    {
        $name = $request->request->get("name");
        $rapport = $request->request->get('rapport');

        if(isset($rapport) && $rapport != "" && isset($name) && $name != "")
        {
            $rapport_veteriniaire = new RapportVeterinaire();
            $rapport_veteriniaire->setDetail($rapport);
            $animal = $this->AnimalRepository->findOneBy(["name"=>$name]);
            $rapport_veteriniaire->setAnimal($animal);

            $em->persist($rapport_veteriniaire);
            $em->flush();

            return new RedirectResponse(
                $this->router->generate("app_home")
            );
        }
    }
}
