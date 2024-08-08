<?php

namespace App\Controller;

use App\Entity\Schedule;
use App\Form\ModifScheduleType;
use App\Repository\ScheduleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;

class ModifSchedulleController extends AbstractController
{
    private ScheduleRepository $ScheduleRepository;
    private RouterInterface $router;

    public function __construct(ScheduleRepository $scheduleRepository, RouterInterface $router) 
    {
        $this->ScheduleRepository = $scheduleRepository;
        $this->router = $router;
    }

    #[Route('/modif-schedulle', name: 'app_modif_schedulle')]
    public function index(): Response
    {
        $form = $this->createForm(ModifScheduleType::class, null, [
            "action" => $this->generateUrl("app_modif_schedule_update"),
            "method" => "post"
        ]);

        return $this->render('modif_schedulle/index.html.twig', [
            'controller_name' => 'ModifSchedulleController',
            "form" => $form, 
        ]);
    }

    #[Route("/modif-scheculeUpdate", name:"app_modif_schedule_update")]
    public function update(Request $request, EntityManagerInterface $em): Response
    {
        $jour = $request->request->get("jour");
        $am = $request->request->get("am");
        $pm = $request->request->get("pm");

        if(isset($jour)&& $jour != "" && isset($am)&& $am != "" && isset($pm) && $pm != "")
        {
            $schedule = $this->ScheduleRepository->findOneBy(["days" => $jour]);
            if($schedule != null)
            {
                $schedule->setAm($am);
                $schedule->setPm($pm);

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
}
