<?php

namespace App\Controller;

use App\Entity\ProjectClose;
use App\Repository\ProjectCloseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/project/close")
 */
class ProjectCloseController extends AbstractController
{
    /**
     * @Route("/", name="project_close_index", methods={"GET"})
     */
    public function index(ProjectCloseRepository $projectCloseRepository): Response
    {
        return $this->render('project_close/index.html.twig', [
            'project_closes' => $projectCloseRepository->findAll(),
        ]);
    }


    /**
     * @Route("/{id}", name="project_close_show", methods={"GET"})
     */
    public function show(ProjectClose $projectClose): Response
    {
        return $this->render('project_close/show.html.twig', [
            'project_close' => $projectClose,
        ]);
    }

    /**
     * @Route("/{id}", name="project_close_delete", methods={"POST"})
     */
    public function delete(Request $request, ProjectClose $projectClose): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projectClose->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($projectClose);
            $entityManager->flush();
        }

        return $this->redirectToRoute('project_close_index', [], Response::HTTP_SEE_OTHER);
    }
}
