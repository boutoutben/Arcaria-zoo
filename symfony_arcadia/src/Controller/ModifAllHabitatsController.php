<?php

namespace App\Controller;

use App\Entity\AllHabitats;
use App\Form\ChoiceModifType;
use App\Form\ModifAllHabitatsCreateType;
use App\Form\ModifAllHabitatsDeleteType;
use App\Form\ModifAllHabitatsUpdateType;
use App\Repository\AllHabitatsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;

#[Route('/modifAllHabitats', name: 'app_modif_all_habitats_')]
class ModifAllHabitatsController extends AbstractController
{
   
    private AllHabitatsRepository $AllHabitatsRepository;
    private RouterInterface $router;

    public function __construct(AllHabitatsRepository $AllHabitatsRepository, RouterInterface $router)
    {
        $this->AllHabitatsRepository = $AllHabitatsRepository;
        $this->router = $router;
    }

    #[Route('/index', name: 'index')]
    public function index(): Response
    {
        
        $habitats = null;
        $choice = $_POST["choice"] ?? '';

        $formChoice = $this->createForm(ChoiceModifType::class, $habitats,[
            "method" => "post",
            "action" => $this->generateUrl("app_modif_all_habitats_index")
        ]);

        $form = $this->createForm(ModifAllHabitatsCreateType::class,$habitats,[
            "action" => $this->generateUrl('app_modif_all_habitats_create'),
            "method"=>"POST",
        ]);
        $formUpdate = $this->createForm(ModifAllHabitatsUpdateType:: class, $habitats,[
            "action" => $this->generateUrl('app_modif_all_habitats_update'),
            "method"=>"POST",
        ]);

        $formDelete = $this->createForm(ModifAllHabitatsDeleteType:: class, $habitats,[
            "action" => $this->generateUrl('app_modif_all_habitats_delete'),
            "method"=>"POST",
        ]);

        return $this->render('modif/index.html.twig', [
            "form" => $form,
            "choice" => $choice,
            "formUpdate" => $formUpdate,
            "formDelete" => $formDelete,
            "formChoice" => $formChoice,
            "title" => "modier les habitats",
            "actionName" => "/modifAllHabitats/index",
            "namePlace" => "habitat"
        ]);
    }


    #[Route('/create', name: 'create')]
    public function create(HttpFoundationRequest $request, EntityManagerInterface $em):Response
    {
        $habitats = new AllHabitats();
        $name = $request->request->get('name');
        $description = $request->request->get("description");
        $image = $request->files->get("image");
        $uploadDir = $this->getParameter('upload_directory');
            
            try {
                $image->move($uploadDir, $image->getClientOriginalName());
                // Success logic here
            } catch (FileException $e) {
                // Handle exception if something happens during file upload
            }

        if(isset($name)&& isset($description)&&isset($image)){
            $habitats->setName($name);
            $habitats->setDescription($description);
            $habitats->setImg($image->getClientOriginalName());

            $em->persist($habitats);
            $em->flush();

            return new RedirectResponse(
                $this->router->generate('app_home')
            );
        }
    }

    #[Route('/update', name: 'update')]
    public function update(HttpFoundationRequest $request, EntityManagerInterface $em):Response
    {
        $habitats = new AllHabitats();
        $nameToChange = $request->request->get('nameToChange');
        $name = $request->request->get('name');
        $description = $request->request->get("description");
        $image = $request->files->get("image");
        $uploadDir = $this->getParameter('upload_directory');

        if(isset($nameToChange)){
            $habitats = $this->AllHabitatsRepository->findOneBy(['name' => $nameToChange]);

            if($habitats != null)
            {
                if($name != ""){
                    $habitats->setName($name);
    
                }
                if($description != ""){
                    $habitats->setDescription($description);
                }
                if(isset($image)){
                    try {
                        $image->move($uploadDir, $image->getClientOriginalName());
                        // Success logic here
                    } catch (FileException $e) {
                        // Handle exception if something happens during file upload
                    }
                    $habitats->setImg($image->getClientOriginalName());
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
    public function delete(HttpFoundationRequest $request, EntityManagerInterface $em)
    {
        $nameToDelete = $request->request->get("nameToDelete");
        $habitats = $this->AllHabitatsRepository->findBy(['name'=>$nameToDelete]);
        if($habitats != null)
        {
            foreach ($habitats as $habitat) {
                $em->remove($habitat);
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
