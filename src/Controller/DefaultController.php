<?php


namespace App\Controller;


use App\Entity\Task;
use App\Form\DescriptionTaskType;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/homepage")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(ProjectRepository $projectRepository): Response
    {
        return $this->render('homepage/homepage.html.twig',[
            'tasksPerUser' => $projectRepository->taskPerUser($this->getUser()->getId())
        ]);
    }

    /**
     * @Route("/{idt}/{idp}/updateDescriptionTask", name="homepage_update", methods={"GET","POST"})
     */
    public function updateDescriptionTask(
        ProjectRepository $projectRepository,
        Request $request,
        int $idt,
        int $idp
    ): Response
    {
        $taskD = new Task();

        $desc = $projectRepository->observationProjectTask($idt,$idp);

        $taskD->setDescription($desc[0]["description"]);

        $form = $this->createForm(DescriptionTaskType::class,$taskD);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $projectRepository->updateProjectTask($idt,$idp,$taskD->getDescription());
            return $this->redirectToRoute('homepage', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('homepage/update.html.twig',[
            'form' => $form
        ]);
    }
    /**
     * @Route("/{idt}/{idp}/updateStateTask", name="homepage_update_state", methods={"GET","POST"})
     */
    public function updateStateTask(
        ProjectRepository $projectRepository,
        int $idt,
        int $idp
    ): Response
    {
        $projectRepository->updateProjectTaskState($idt,$idp,'finished');
        return $this->redirectToRoute('homepage', [], Response::HTTP_SEE_OTHER);

    }

}