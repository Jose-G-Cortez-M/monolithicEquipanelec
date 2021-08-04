<?php

namespace App\Controller;

use DateTime;
use App\Entity\Tool;
use App\Entity\Cable;
use App\Entity\Material;
use App\Entity\Movement;
use App\Form\MovementType;
use App\Repository\ToolRepository;
use App\Repository\CableRepository;
use App\Repository\MaterialRepository;
use App\Repository\MovementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/movement")
 */
class MovementController extends AbstractController
{
    /**
     * @Route("/", name="movement_index", methods={"GET"})
     */
    public function index(MovementRepository $movementRepository): Response
    {
        return $this->render('movement/index.html.twig', [
            'movements' => $movementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/list", name="movement_list", methods={"GET"})
     */
    public function listMovement(MovementRepository $movementRepository): Response
    {
        return $this->render('movement/filteredMovement.html.twig', [
            'movements' => $movementRepository->findBy(array('projects'=> null)),
        ]);
    }

    /**
     * @Route("/newmaterial/{id}", name="movement_new_material", methods={"GET","POST"})
     */
    public function newMaterial(Request $request,$id): Response
    {
        $movement = new Movement();
        $movement->setOrderdate($this->setDate());

        $material = $this->foundMaterialById($id);

        $movement->setMaterials($material);

        $form = $this->createForm(MovementType::class, $movement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($movement->getMaterials()->getStock()>=$movement->getQuantity())
            {
                $remaining = ($movement->getMaterials()->getStock())-($movement->getQuantity());
                $material->setStock($remaining);
                $movement->setMaterials($material);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($movement);
                $entityManager->flush();
                return $this->redirectToRoute('movement_list', [], Response::HTTP_SEE_OTHER);
            }else{
                echo "<h2>Ops! You don't have enough materials in the warehouse</h2>";
            }
        }

        return $this->renderForm('movement/new.html.twig', [
            'movement' => $movement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/newcable/{id}", name="movement_new_cable", methods={"GET","POST"})
     */
    public function newCable($id, Request $request): Response
    {
        $movement = new Movement();
        $movement->setOrderdate($this->setDate());

        $cable = $this->foundCableById($id);

        $movement->setCables($cable);
        $form = $this->createForm(MovementType::class, $movement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($movement->getCables()->getAvailability()>=$movement->getQuantity())
            {
                $remaining = ($movement->getCables()->getAvailability())-($movement->getQuantity());
                $cable->setAvailability($remaining);
                $movement->setCables($cable);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($movement);
                $entityManager->flush();
                return $this->redirectToRoute('movement_list', [], Response::HTTP_SEE_OTHER);
            }else{
                echo "<h2>Ops! You don't have enough cables in the warehouse</h2>";
            }
        }

        return $this->renderForm('movement/new.html.twig', [
            'movement' => $movement,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/newtool/{id}", name="movement_new_tool", methods={"GET","POST"})
     */
    public function newTool(Request $request,$id): Response
    {
        $movement = new Movement();
        $movement->setOrderdate($this->setDate());

        $tool = $this->foundToolById($id);

        $movement->setTools($tool);
        $form = $this->createForm(MovementType::class, $movement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($movement->getTools()->getStock()>=$movement->getQuantity())
            {
                $remaining = ($movement->getTools()->getStock())-($movement->getQuantity());
                $tool->setStock($remaining);
                $movement->setTools($tool);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($movement);
                $entityManager->flush();
                return $this->redirectToRoute('movement_list', [], Response::HTTP_SEE_OTHER);
            }else{
                echo "<h2> Ops! You don't have enough tools in the warehouse</h2>";
            }
        }

        return $this->renderForm('movement/new.html.twig', [
            'movement' => $movement,
            'form' => $form,
        ]);

    }


    /**
     * @Route("/{id}/edit", name="movement_edit", methods={"GET","POST"})
     */
    public function edit(
        Request $request,
        Movement $movement,
        MaterialRepository $materialRepository,
        CableRepository $cableRepository,
        ToolRepository $toolRepository
        ): Response
    {
        $mvOld = $movement->getQuantity();
        $form = $this->createForm(MovementType::class, $movement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->extracted($movement, $materialRepository, $mvOld, $cableRepository, $toolRepository);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('movement_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('movement/edit.html.twig', [
            'movement' => $movement,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{id}", name="movement_delete", methods={"POST"})
     */
    public function delete(
        Request $request,
        Movement $movement
    ): Response
    {
        $mvOld = $movement->getQuantity();
        if ($this->isCsrfTokenValid('delete'.$movement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $this->extracted1($movement, $mvOld, $entityManager);
            $entityManager->remove($movement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('movement_list', [], Response::HTTP_SEE_OTHER);
    }


    public function setDate(): DateTime
    {
        date_default_timezone_set('America/Guayaquil');
        return new DateTime('now');
    }

    public function foundCableById($id)
    {
        $em = $this->getDoctrine()->getRepository(Cable::class);
        return $em->find($id);

    }
    public function foundMaterialById($id)
    {
        $em = $this->getDoctrine()->getRepository(Material::class);
        return $em->find($id);
    }

    private function foundToolById($id)
    {
        $em = $this->getDoctrine()->getRepository(Tool::class);
        return $em->find($id);
    }

    public function extracted(Movement $movement, MaterialRepository $materialRepository, ?float $mvOld, CableRepository $cableRepository, ToolRepository $toolRepository): void
    {
        if ($movement->getMaterials() != null) {
            $material = $materialRepository->find($movement->getMaterials()->getId());
            $movement->returnToMaterial($material, $mvOld);
        } elseif ($movement->getCables() != null) {
            $cable = $cableRepository->find($movement->getCables()->getId());
            $movement->returnToCable($cable, $mvOld);
        } elseif ($movement->getTools() != null) {
            $tool = $toolRepository->find($movement->getTools()->getId());
            $movement->returnToTool($tool, $mvOld);
        }
    }
    /**
     * @param Movement $movement
     * @param float|null $mvOld
     * @param $entityManager
     */
    public function extracted1(Movement $movement, ?float $mvOld, $entityManager): void
    {
        if ($movement->getMaterials() != null) {
            $material = $movement->getMaterials();
            $material->setStock($material->getStock() + $mvOld);
            $entityManager->persist($material);
            $entityManager->flush();
        }
        if ($movement->getTools() != null) {
            $tool = $movement->getTools();
            $tool->setStock($tool->getStock() + $mvOld);
            $entityManager->persist($tool);
            $entityManager->flush();
        }
        if ($movement->getCables() != null) {
            $cable = $movement->getCables();
            $cable->setAvailability($cable->getAvailability() + $mvOld);
            $entityManager->persist($cable);
            $entityManager->flush();
        }
    }

}
