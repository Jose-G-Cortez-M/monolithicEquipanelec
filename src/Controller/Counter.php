<?php

namespace App\Controller;


use Dompdf\Dompdf;
use App\Entity\Project;
use App\Repository\TaskRepository;
use App\Repository\ToolRepository;
use App\Repository\CableRepository;
use App\Repository\ClientRepository;
use App\Form\FilterProjectsCountType;
use App\Repository\ProjectRepository;
use App\Repository\MaterialRepository;
use App\Repository\ProjectCloseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/counter")
 */
class Counter extends abstractController
{
    /**
     * @Route ("/counter", name="counter", methods={"GET","POST"} )
     */
    public function counter(
        Request $request,
        ProjectCloseRepository $projectCloseRepository
    ): Response
    {

        $project = new Project();

        $inventoryMaterials = $projectCloseRepository->totalInventoryMaterials();
        $inventoryCables = $projectCloseRepository->totalInventoryCables();
        $inventoryTools = $projectCloseRepository->totalInventoryTools();
        $costProjectActive = $projectCloseRepository->totalCostProjectsActive();
        $commercialValueClosed = $projectCloseRepository->commercialValueProjectClosed();
        $totalCostClosed = $projectCloseRepository->totalCostProjectsClosed();

        $form = $this->createForm(FilterProjectsCountType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $startDate = $project->getStartDate()->format('Y/m/d');
            $endDate = $project->getEndTime()->format('Y/m/d');
            $costProjectActive = $projectCloseRepository->totalCostProjectsActiveFilter($startDate,$endDate);
            $commercialValueClosed = $projectCloseRepository->commercialValueClosedFilter($startDate,$endDate);
            $totalCostClosed = $projectCloseRepository->totalCostClosedFilter($startDate,$endDate);
        }

        return $this->renderForm('counter/index.html.twig', [
            'inventoryMaterials' => (float)$inventoryMaterials[0]['totalInventoryMaterials'],
            'inventoryCables' => (float)$inventoryCables[0]['totalInventoryCables'],
            'inventoryTools'=> (float)$inventoryTools[0]['totalInventoryTools'],
            'costProjectActive' => (float)$costProjectActive[0]['totalCostProjectActive'],
            'commercialValueClosed' => (float) $commercialValueClosed[0]['commercialValueProjectClosed'],
            'totalCostClosed' => (float)$totalCostClosed[0]['totalCostProjectsClosed'],
            'project' => $project,
            'form' => $form,
        ]);
    }

    /**
     * @Route ("/report_tool", name="report_tool", methods={"GET"} )
     */
    public function reportTool(
        Request $request,
        ToolRepository $toolRepository
        )
    {
    // Definimos las opciones de PDF
   
      /*$pdfOptions = new Options();
   
      $pdfOptions->set('defaultFont', 'Arial'));*/

    // Instalamos Dompdf
   
      $dompdf = new Dompdf();
   
      $content = stream_context_create([
        'ssl' => [
          'verify_peer' => FALSE,
          'verify_peer_name' => FALSE,
          'allow_self_signed' => TRUE,
        ]
      ]);
   
      $dompdf->setHttpContext($content);
   
      // Generamos el html
      $tools = $toolRepository->findAll();
   
      $html = $this->renderView('counter/reportTool.html.twig', [
        'tools' => $tools 
     ]);
   
      $dompdf->loadHtml($html);
      $dompdf->setPaper('A4', 'portrait');
      $dompdf->render();
   
      // Generamos el html
   
      $file = 'user-data-' . $this->getUser()->getId() . '.pdf';
   
    // Enviamos el PDF al navegador
   
      $dompdf->stream($file, [
        'Attachement' => true
      ]);
   
      return new Response();
    }

    /**
     * @Route ("/report_material", name="report_material", methods={"GET"} )
     */
    public function reportMaterial(
      Request $request,
      MaterialRepository $materialRepository
      )
  {
  // Definimos las opciones de PDF
 
    /*$pdfOptions = new Options();
 
    $pdfOptions->set('defaultFont', 'Arial'));*/

  // Instalamos Dompdf
 
    $dompdf = new Dompdf();
 
    $content = stream_context_create([
      'ssl' => [
        'verify_peer' => FALSE,
        'verify_peer_name' => FALSE,
        'allow_self_signed' => TRUE,
      ]
    ]);
 
    $dompdf->setHttpContext($content);
 
    // Generamos el html
    $material = $materialRepository->findAll();
 
    $html = $this->renderView('counter/reportMaterial.html.twig', [
      'materials' => $material 
   ]);
 
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
 
    // Generamos el html
 
    $file = 'user-data-' . $this->getUser()->getId() . '.pdf';
 
  // Enviamos el PDF al navegador
 
    $dompdf->stream($file, [
      'Attachement' => true
    ]);
 
    return new Response();
  }
    /**
     * @Route ("/report_cable", name="report_cable", methods={"GET"} )
     */
    public function reportCable(
      Request $request,
      CableRepository $cableRepository
      )
  {
  // Definimos las opciones de PDF
 
    /*$pdfOptions = new Options();
 
    $pdfOptions->set('defaultFont', 'Arial'));*/

  // Instalamos Dompdf
 
    $dompdf = new Dompdf();
 
    $content = stream_context_create([
      'ssl' => [
        'verify_peer' => FALSE,
        'verify_peer_name' => FALSE,
        'allow_self_signed' => TRUE,
      ]
    ]);
 
    $dompdf->setHttpContext($content);
 
    // Generamos el html
    $cable = $cableRepository->findAll();
 
    $html = $this->renderView('counter/reportCable.html.twig', [
      'cables' => $cable 
   ]);
 
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
 
    // Generamoscable
 
    $file = 'user-data-' . $this->getUser()->getId() . '.pdf';
 
  // Enviamos el PDF al navegador
 
    $dompdf->stream($file, [
      'Attachement' => true
    ]);
 
    return new Response();
  }

    /**
     * @Route ("/report_client", name="report_client", methods={"GET"} )
     */
    public function reportClient(
      Request $request,
      ClientRepository $clientRepository
      )
  {
  // Definimos las opciones de PDF
 
    /*$pdfOptions = new Options();
 
    $pdfOptions->set('defaultFont', 'Arial'));*/

  // Instalamos Dompdf
 
    $dompdf = new Dompdf();
 
    $content = stream_context_create([
      'ssl' => [
        'verify_peer' => FALSE,
        'verify_peer_name' => FALSE,
        'allow_self_signed' => TRUE,
      ]
    ]);
 
    $dompdf->setHttpContext($content);
 
    // Generamos el html
    $clients = $clientRepository->findAll();
 
    $html = $this->renderView('counter/reportClient.html.twig', [
      'clients' => $clients 
   ]);
 
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
 
    // Generamos el html
 
    $file = 'user-data-' . $this->getUser()->getId() . '.pdf';
 
  // Enviamos el PDF al navegador
 
    $dompdf->stream($file, [
      'Attachement' => true
    ]);
 
    return new Response();
  }

  /**
     * @Route ("/report_task", name="report_task", methods={"GET"} )
     */
    public function reportTask(
      Request $request,
      TaskRepository $taskRepository
      )
  {
  // Definimos las opciones de PDF
 
    /*$pdfOptions = new Options();
 
    $pdfOptions->set('defaultFont', 'Arial'));*/

  // Instalamos Dompdf
 
    $dompdf = new Dompdf();
 
    $content = stream_context_create([
      'ssl' => [
        'verify_peer' => FALSE,
        'verify_peer_name' => FALSE,
        'allow_self_signed' => TRUE,
      ]
    ]);
 
    $dompdf->setHttpContext($content);
 
    // Generamos el html
    $tasks = $taskRepository->findAll();
 
    $html = $this->renderView('counter/reportTask.html.twig', [
      'tasks' => $tasks 
   ]);
 
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
 
    // Generamos el html
 
    $file = 'user-data-' . $this->getUser()->getId() . '.pdf';
 
  // Enviamos el PDF al navegador
 
    $dompdf->stream($file, [
      'Attachement' => true
    ]);
 
    return new Response();
  }



  /**
     * @Route ("/report_project", name="report_project", methods={"GET"} )
     */
    public function reportProject(
      Request $request,
      ProjectRepository $projectRepository
      )
  {
  // Definimos las opciones de PDF
 
    /*$pdfOptions = new Options();
 
    $pdfOptions->set('defaultFont', 'Arial'));*/

  // Instalamos Dompdf
 
    $dompdf = new Dompdf();
 
    $content = stream_context_create([
      'ssl' => [
        'verify_peer' => FALSE,
        'verify_peer_name' => FALSE,
        'allow_self_signed' => TRUE,
      ]
    ]);
 
    $dompdf->setHttpContext($content);
 
    // Generamos el html
    $projects = $projectRepository->findAll();
 
    $html = $this->renderView('counter/reportProject.html.twig', [
      'projects' => $projects 
   ]);
 
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
 
    // Generamos el html
 
    $file = 'user-data-' . $this->getUser()->getId() . '.pdf';
 
  // Enviamos el PDF al navegador
 
    $dompdf->stream($file, [
      'Attachement' => true
    ]);
 
    return new Response();
  }


}