<?php

namespace App\Controller;

use App\Entity\Services;
use App\Form\ChoiceModifType;
use App\Form\ModifServicesCreateType;
use App\Form\ModifServicesDeleteType;
use App\Form\ModifServicesUpdateType;
use App\Repository\ServicesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;

#[Route('/modifServices', name: 'app_modif_services_')]
class ModifServicesControler extends AbstractController
{
    private ServicesRepository $ServicesRepository;
    private RouterInterface $router;

    public function __construct(ServicesRepository $ServicesRepository, RouterInterface $router)
    {
        $this->ServicesRepository = $ServicesRepository;
        $this->router = $router;
    }

    #[Route('/index', name: 'index')]
    public function index(): Response
    {
        
        $services = null;
        $choice = $_POST["choice"] ?? '';

        $formChoice = $this->createForm(ChoiceModifType::class, $services,[
            "method" => "post",
            "action" => $this->generateUrl("app_modif_services_index")
        ]);

        $form = $this->createForm(ModifServicesCreateType::class,$services,[
            "action" => $this->generateUrl('app_modif_services_create'),
            "method"=>"POST",
        ]);
        $formUpdate = $this->createForm(ModifServicesUpdateType::class, $services,[
            "action" => $this->generateUrl('app_modif_services_update'),
            "method"=>"POST",
        ]);

        $formDelete = $this->createForm(ModifServicesDeleteType:: class, $services,[
            "action" => $this->generateUrl('app_modif_services_delete'),
            "method"=>"POST",
        ]);

        return $this->render('modif/index.html.twig', [
            "form" => $form,
            "choice" => $choice,
            "formUpdate" => $formUpdate,
            "formDelete" => $formDelete,
            "formChoice" => $formChoice,
            "title" => "modifier les services",
            "actionName" => "/modifServices/index",
            "namePlace" => "service"
        ]);
    }


    #[Route('/create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $em):Response
    {
        $services = new Services();
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
            $services->setName($name);
            $services->setDescription($description);
            $services->setImg($image->getClientOriginalName());

            $em->persist($services);
            $em->flush();

            return new RedirectResponse(
                $this->router->generate('app_home')
            );
        }
    }

    #[Route('/update', name: 'update')]
    public function update(Request $request, EntityManagerInterface $em):Response
    {
        $services = new Services();
        $nameToChange = $request->request->get('nameToChange');
        $name = $request->request->get('name');
        $description = $request->request->get("description");
        $image = $request->files->get("image");
        $uploadDir = $this->getParameter('upload_directory');

        if(isset($nameToChange)){
            $services = $this->ServicesRepository->findOneBy(['name' => $nameToChange]);   
            if($services != null)
            {
                if($name != ""){
                $services->setName($name);

                }
                if($description != ""){
                    $services->setDescription($description);
                }
                if(isset($image)){
                    try {
                        $image->move($uploadDir, $image->getClientOriginalName());
                        // Success logic here
                    } catch (FileException $e) {
                        // Handle exception if something happens during file upload
                    }
                    $services->setImg($image->getClientOriginalName());
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
        $services = $this->ServicesRepository->findOneBy(['name'=>$nameToDelete]);
        if($services != null)
        {
            $em->remove($services);

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
