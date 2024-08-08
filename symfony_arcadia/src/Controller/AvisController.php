<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Form\CreateAvisType;
use App\Repository\AvisRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Global_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;


#[Route('/avis', name: 'app_avis_')]
class AvisController extends AbstractController
{
    private RouterInterface $router;
    private AvisRepository $avisRepository;

    public function __construct(RouterInterface $router, AvisRepository $avisRepository)
    {
        $this->router = $router;
        $this->avisRepository = $avisRepository;
    }

    #[Route('/index', name: 'index')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $Avis = new Avis();
        $form = $this->createForm(CreateAvisType::class, $Avis,[
            "method" => "POST",
        ]);

        



        $pseudo = $request->request->get("pseudo");
        $avis = $request->request->get("avis");
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $Avis->setPseudo($pseudo);
            $Avis->setAvis($avis);
            $Avis->setValid(false);
            dump($form->getData()); // Shows the data the form is working with
            dump($form);
            dd($form->getErrors(true, true)); // Shows the validation errors
        }
        if ($form->isSubmitted()&&$form->isValid())
        {
            $em->persist($Avis);
            $em->flush();

            return new RedirectResponse(
                $this->router->generate('app_home')
            );
        }

        return $this->render('avis/index.html.twig', [
            'controller_name' => 'AvisController',
            "form" => $form->createView(),
        ]);
    }
    #[Route("/create", name: "create")]
    public function create(Request $request, EntityManagerInterface $em):Response
    {


        $pseudo = $request->request->get("pseudo");
        $avis = $request->request->get("avis");


        $AvisEntity = new Avis();

        $form = $this->createForm(CreateAvisType::class, null);

        $form->handleRequest($request);



        if ($form->isSubmitted())
        {
            
            $AvisEntity->setPseudo($pseudo);
            $AvisEntity->setAvis($avis);
            $AvisEntity->setValid(false);

            $em->persist($AvisEntity);
            $em->flush();

            return new RedirectResponse(
                $this->router->generate('app_home')
            );
        }
        else{
            return new RedirectResponse(
                $this->router->generate('app_avis_index')
            );
        }
    }

    #[Route("/yes/{id}", name:"yes")]
    public function yes($id, EntityManagerInterface $em):Response
    {
        $avis = $this->avisRepository->findOneBy(['id' => $id]);
        $avis->setValid(true);

        $em->flush();

        return new RedirectResponse(
            $this->router->generate("app_employee")
        );
    }

    #[Route("/no/{id}", name: "no")]
    public function no($id, EntityManagerInterface $em): Response
    {
        $avis = $this->avisRepository->findOneBy(["id" => $id]);
        $em->remove($avis); 
        $em->flush();

        return new RedirectResponse(
            $this->router->generate("app_employee")
        );
    }
}
