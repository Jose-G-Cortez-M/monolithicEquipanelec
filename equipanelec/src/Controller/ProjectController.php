<?php

namespace App\Controller;

use App\Entity\ProjectClose;
use DateTime;
use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/project")
 */
class ProjectController extends AbstractController
{
    /**
     * @Route("/", name="project_index", methods={"GET"})
     */
    public function index(ProjectRepository $projectRepository): Response
    {
        $projects = $projectRepository->findAll();


        foreach ($projects as $project){

            $idProject = $project->getId();

            //cost of all materials used in the project
            $costInventory = $projectRepository->queryCostInventory($idProject);
            $cI = (float)($costInventory[0]["totalInventory"]);

            //Cost of all project tasks
            $costTask = $projectRepository->queryCostTask($idProject);
            $cT = (float)$costTask[0]["totalTask"];

            //Total project cost
            $totalCost = $cT+$cI;
            //Commercial Price
            //Commercial project with an additional 12% to the total cost of the project
            $commercial = $totalCost+(round($totalCost*0.12,2));

            $project->setTotalCostTask($cT);
            $project->setTotalCostInventory($cI);
            $project->setTotalCost($totalCost);
            $project->setCommercialValue($commercial);

            $allTask = $projectRepository->allTask($idProject);
            $aT = (float)($allTask[0]["taskAll"]);

            $finishTask = $projectRepository->taskFinish($idProject);
            $fT = (float)($finishTask[0]["taskFinish"]);

            if($aT!=0){
                $result = ($fT*100)/$aT;
                $project->setAdvances(round($result,2));
            }

            $this->getDoctrine()->getManager()->flush();
            
        }


        return $this->render('project/index.html.twig', [
            'projects' => $projectRepository->findAll(),
            'message' => ''
        ]);
    }

    /**
     * @Route("/new", name="project_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $project = new Project();

        date_default_timezone_set('America/Guayaquil');
        $project->setRegistrationDate($this->setDate()) ;

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('project/new.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="project_show", methods={"GET"})
     */
    public function show(Project $project): Response
    {
        return $this->render('project/show.html.twig', [
            'project' => $project,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="project_edit", methods={"GET","POST"})
     */
    public function edit(
        Request $request,
        Project $project
    ): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('project/edit.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{id}", name="project_delete", methods={"POST"})
     */
    public function delete(
        Request $request,
        Project $project
    ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($project);
            $entityManager->flush();
        }

        return $this->redirectToRoute('project_index', [], Response::HTTP_SEE_OTHER);
    }
    public function setDate(): DateTime
    {
        date_default_timezone_set('America/Guayaquil');
        return new DateTime('now');
    }


    /**
     * @Route("/{idP}/finish", name="project_finish", methods={"GET","POST"})
     */
    public function finishProject(
        int $idP,
        ProjectRepository $projectRepository
    ): Response
    {
        $project = $projectRepository->find($idP);
        if (100 == $project->getAdvances())
        {
            $projectClose = new ProjectClose();

            $material = $projectRepository->costMaterialPerProject($idP);
            $tool = $projectRepository->costToolPerProject($idP);
            $cable = $projectRepository->costCablePerProject($idP);
            $allTask = $projectRepository->allTaskEndProject($idP);

            $date['material'] = $material;
            $date['tool'] = $tool;
            $date['cable'] = $cable;
            $date['allTask'] = $allTask;


            $projectClose->setContractNumber($project->getContractNumber());
            $projectClose->setName($project->getName());
            $projectClose->setRegistrationDate($project->getRegistrationDate());
            $projectClose->setStartDate($project->getStartDate());
            $projectClose->setEndTime($project->getEndTime());
            $projectClose->setTotalCostTask($project->getTotalCostTask());
            $projectClose->setTotalCostInventory($project->getTotalCostInventory());
            $projectClose->setTotalCost($project->getTotalCost());
            $projectClose->setCommercialValue($project->getCommercialValue());

            $projectClose->setDate($date);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($projectClose);
            $entityManager->flush();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($project);
            $entityManager->flush();
            return $this->redirectToRoute('project_index', [], Response::HTTP_SEE_OTHER);

        }else{
            return $this->render('project/index.html.twig', [
                'message' => 'Tienes tareas pedientes. Termina las tareas para poder cerrar el proyecto.',
                'projects' => $projectRepository->findAll()
            ]);
        }

    }

    /**
     * @Route("/{idP}/observations", name="project_observations", methods={"GET"})
     */
    public function showObservations(ProjectRepository $projectRepository,int $idP): Response
    {
        $projects = $projectRepository->showObservationProjectTask($idP);
        return $this->render('project/showObservations.html.twig', [
            'projects' => $projects
        ]);
    }


}
