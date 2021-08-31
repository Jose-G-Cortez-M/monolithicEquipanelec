<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\TaskAddProjectType;
use App\Form\UserAddProjectType;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/addprojects")
 */
class AddProjectController extends abstractController
{

    /**
     * @Route ("/{id}/adduser", name="user_add_project" , methods={"GET","POST"})
     */
    public function userAddProject(
        int $id,
        ProjectRepository $projectRepository,
        Project $project,
        Request $request
    ): Response
    {

        $queryProject = $projectRepository->find($id);
        $project->setName($queryProject->getName());
        $project->setRegistrationDate($queryProject->getRegistrationDate());
        $form = $this->createForm(UserAddProjectType::class,$project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('userAddProject/index.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);

    }

    /**
     * @Route ("/{id}/addtask", name="task_add_project" , methods={"GET","POST"})
     */
    public function taskAddProject(
        int $id,
        Project $project,
        ProjectRepository $projectRepository,
        Request $request
    ): Response
    {
        $queryProject = $projectRepository->find($id);
        $project->setName($queryProject->getName());
        $project->setRegistrationDate($queryProject->getRegistrationDate());


        $form = $this->createForm(TaskAddProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('taskAddProject/index.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

}