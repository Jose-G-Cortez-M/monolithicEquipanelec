<?php

namespace App\Controller;


use App\Entity\Project;
use App\Form\FilterProjectsCountType;
use App\Repository\ProjectCloseRepository;
use App\Repository\ToolRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Dompdf\Dompdf;


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
     * @Route ("/report", name="report", methods={"GET"} )
     */
    public function dataDownload(
        Request $request,
        ToolRepository $toolRepository
        )
    {
      // On définitions les options du PDF
   
      /*$pdfOptions = new Options();
   
      $pdfOptions->set('defaultFont', 'Arial'));*/
   
      // On instancie Dompdf
   
      $dompdf = new Dompdf();
   
      $content = stream_context_create([
        'ssl' => [
          'verify_peer' => FALSE,
          'verify_peer_name' => FALSE,
          'allow_self_signed' => TRUE,
        ]
      ]);
   
      $dompdf->setHttpContext($content);
   
      // On génère le html
      $tools = $toolRepository->findAll();
   
      $html = $this->renderView('counter/report.html.twig', [
        'tools' => $tools 
     ]);
   
      $dompdf->loadHtml($html);
      $dompdf->setPaper('A4', 'portrait');
      $dompdf->render();
   
      // On génère un nom de ficher
   
      $file = 'user-data-' . $this->getUser()->getId() . '.pdf';
   
      // On envoie le PDF au navigateur
   
      $dompdf->stream($file, [
        'Attachement' => true
      ]);
   
      return new Response();
    }

}