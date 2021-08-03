<?php

namespace App\Controller;

use App\Entity\Tool;
use App\Entity\Cable;
use App\Entity\Material;
use App\Entity\Movement;
use App\Form\MovementType;
use App\Repository\CableRepository;
use App\Repository\MaterialRepository;
use App\Repository\MovementRepository;
use App\Repository\ToolRepository;
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
    public function listmovement(MovementRepository $movementRepository): Response
    {
        return $this->render('movement/filteredmovement.html.twig', [
            'movements' => $movementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/newmaterial/{id}", name="movement_new_material", methods={"GET","POST"})
     */
    public function newMaterial(Request $request,$id): Response
    {
        $messaging = "";
        $movement = new Movement();
        $material = new Material();
        $movement->setOrderdate($this->setDate());
        $em = $this->getDoctrine()->getRepository(Material::class);
        $material = $em->find($id);
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
                echo $messaging = "<h2>Opss! No tienes suficientes materiales en bodega :P</h2>";
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
    public function newCable(Request $request,$id): Response
    {
        $messaging = "";
        $movement = new Movement();
        $cable = new Cable();
        $movement->setOrderdate($this->setDate());
        $em = $this->getDoctrine()->getRepository(Cable::class);
        $cable = $em->find($id);
        $movement->setCables($cable);

        $form = $this->createForm(MovementType::class, $movement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($movement->getCables()->getAvailability()>=$movement->getQuantity())
            {
                $remaining = ($movement->getCables()->getAvailability())-($movement->getQuantity());
                $cable->setAvailablemeter($remaining);
                $movement->setCables($cable);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($movement);
                $entityManager->flush();
                return $this->redirectToRoute('movement_list', [], Response::HTTP_SEE_OTHER);
            }else{
                echo $messaging = "<h2>Opss! No tienes suficientes cables en bodega :P</h2>";
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
        $messaging = "";
        $movement = new Movement();
        $tool = new Tool();
        $movement->setOrderdate($this->setDate());
        $em = $this->getDoctrine()->getRepository(Tool::class);
        $tool = $em->find($id);
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
                echo $messaging = "<h2>Opss! No tienes suficientes herramientas en bodega :P</h2>";
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
            if($movement->getMaterials()!= null)
            {
                $material = new Material();
                $material = $materialRepository->find($movement->getMaterials()->getId());
                $movement->returnToMaterial($material,$mvOld);
            }
            elseif ($movement->getCables()!=null)
            {
                $cable = new Cable();
                $cable = $cableRepository->find($movement->getCables()->getId());
                $movement->returnToCable($cable,$mvOld);
            }
            elseif ($movement->getTools()!=null)
            {
                $tool = new Tool();
                $tool = $toolRepository->find($movement->getTools()->getId());
                $movement->returnToTool($tool,$mvOld);
            }
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
    public function delete(Request $request, Movement $movement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$movement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($movement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('movement_list', [], Response::HTTP_SEE_OTHER);
    }


    public function setDate(): \DateTime
    {
        date_default_timezone_set('America/Guayaquil');
        return new \DateTime('now');
    }

}
