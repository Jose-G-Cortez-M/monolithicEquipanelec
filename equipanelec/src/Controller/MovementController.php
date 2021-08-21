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
    public function index(
        MovementRepository $movementRepository
    ): Response
    {
        $movements = $movementRepository->findAll();

        $this->totalCostMovement($movements);

        return $this->render('movement/index.html.twig', [
            'movements' => $movementRepository->findAll(),
            'message' => $message=""
        ]);
    }

    /**
     * @Route("/list", name="movement_list", methods={"GET"})
     */
    public function listMovement(MovementRepository $movementRepository): Response
    {
        $movements = $movementRepository->findAll();

        $this->totalCostMovement($movements);

        return $this->render('movement/filteredMovement.html.twig', [
            'movements' => $movementRepository->findBy(['projects'=> null]),
            'message' => $message=""
        ]);
    }

    /**
     * @Route("/newmaterial/{id}", name="movement_new_material", methods={"GET","POST"})
     */
    public function newMaterial(
        int $id,
        Request $request
    ): Response
    {
        $message= "";
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
                $message = "<h2>¡Ops! No tienes suficientes materiales en el almacén.</h2>";
            }
        }

        return $this->renderForm('movement/new.html.twig', [
            'movement' => $movement,
            'form' => $form,
            'message'=> $message
        ]);
    }

    /**
     * @Route("/newcable/{id}", name="movement_new_cable", methods={"GET","POST"})
     */
    public function newCable(
        int $id,
        Request $request
    ): Response
    {
        $message= "";
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
                $message = "<h2>¡Ops! No tienes suficientes cables en el almacén.</h2>";
            }
        }

        return $this->renderForm('movement/new.html.twig', [
            'movement' => $movement,
            'form' => $form,
            'message' => $message
        ]);
    }


    /**
     * @Route("/newtool/{id}", name="movement_new_tool", methods={"GET","POST"})
     */
    public function newTool(
        int $id,
        Request $request
    ): Response
    {
        $message = "";

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
                $message = "<h2> ¡Ops! No tienes suficientes herramientas en el almacén.</h2>";
            }
        }

        return $this->renderForm('movement/new.html.twig', [
            'movement' => $movement,
            'form' => $form,
            'message' => $message
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
        $message="";
        $mvOld = $movement->getQuantity();
        $form = $this->createForm(MovementType::class, $movement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message=$this->backToInventoryByEdit($movement, $materialRepository, $cableRepository, $toolRepository, $mvOld);
            if($message == ''){
                $this->getDoctrine()->getManager()->flush();
                if($this->isGranted("ROLE_CELLAR")) {
                    return $this->redirectToRoute('movement_list', [], Response::HTTP_SEE_OTHER);
                }else{
                    return $this->redirectToRoute('movement_index', [], Response::HTTP_SEE_OTHER);
                }
            }
        }

        return $this->renderForm('movement/edit.html.twig', [
            'movement' => $movement,
            'form' => $form,
            'message' => $message

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
            $this->returnToInventoryByElimination($movement, $mvOld, $entityManager);
            $entityManager->remove($movement);
            $entityManager->flush();
        }

        if($this->isGranted("ROLE_CELLAR")) {
            return $this->redirectToRoute('movement_list', [], Response::HTTP_SEE_OTHER);
        }else{
            return $this->redirectToRoute('movement_index', [], Response::HTTP_SEE_OTHER);
        }
    }


    public function setDate(): DateTime
    {
        date_default_timezone_set('America/Guayaquil');
        return new DateTime('now');
    }

    /**
     * @param int $id
     * @return mixed|object|null
     */
    public function foundCableById(int $id)
    {
        $em = $this->getDoctrine()->getRepository(Cable::class);
        return $em->find($id);

    }

    /**
     * @param int $id
     * @return mixed|object|null
     */
    public function foundMaterialById(int $id)
    {
        $em = $this->getDoctrine()->getRepository(Material::class);
        return $em->find($id);
    }

    /**
     * @param int $id
     * @return mixed|object|null
     */
    private function foundToolById(int $id)
    {
        $em = $this->getDoctrine()->getRepository(Tool::class);
        return $em->find($id);
    }


    /**
     * @param Movement $movement
     * @param MaterialRepository $materialRepository
     * @param CableRepository $cableRepository
     * @param ToolRepository $toolRepository
     * @param float|null $mvOld
     * @return string
     */
    public function backToInventoryByEdit(
        Movement $movement,
        MaterialRepository $materialRepository,
        CableRepository $cableRepository,
        ToolRepository $toolRepository,
        ?float $mvOld
    ): string
    {
        $message = '';
        if ($movement->getMaterials() != null) {
            if($movement->getMaterials()->getStock()>=$movement->getQuantity())
            {
                $material = $materialRepository->find($movement->getMaterials()->getId());
                $diff = ($mvOld - $movement->getQuantity());
                $add = ($movement->getMaterials()->getStock()) + ($diff);
                $material->setStock($add);
                $movement->setTotalCost($movement->getMaterials()->getSalePrice()*$movement->getQuantity());
                $movement->setMaterials($material);
                $message = '';
            }else{
                $message = "<h2>¡Ops! No tienes suficientes materiales en el almacén.</h2>";
            }
        } elseif ($movement->getCables() != null) {
            if($movement->getCables()->getAvailability()>=$movement->getQuantity())
            {
                $cable = $cableRepository->find($movement->getCables()->getId());
                $diff = ($mvOld - $movement->getQuantity());
                $add = ($movement->getCables()->getAvailability()) + ($diff);
                $cable->setAvailability($add);
                $movement->setTotalCost($movement->getCables()->getSalePrice()*$movement->getQuantity());
                $movement->setCables($cable);
                $message = '';
            }else{
                $message = "<h2>¡Ops! No tienes suficientes cables en el almacén.</h2>";

            }
        } elseif ($movement->getTools() != null) {
            if($movement->getTools()->getStock()>=$movement->getQuantity())
            {
                $tool = $toolRepository->find($movement->getTools()->getId());
                $diff = ($mvOld - $movement->getQuantity());
                $add = ($movement->getTools()->getStock()) + ($diff);
                $tool->setStock($add);
                $movement->setTotalCost($movement->getTools()->getPrice()*$movement->getQuantity());
                $movement->setTools($tool);
                $message='';
            }else{
                $message = "<h2> ¡Ops! No tienes suficientes herramientas en el almacén.</h2>";
            }

        }
        return $message;
    }


    public function returnToInventoryByElimination(
        Movement $movement,
        ?float $mvOld,
        $entityManager
    ): void
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

    /**
     * @param array $movements
     */
    public function totalCostMovement(array $movements): void
    {
        foreach ($movements as $movement) {
            if ($movement->getMaterials() != null) {

                $movement->setCommercialValue(($movement->getMaterials()->getSalePrice()) * ($movement->getQuantity()));
                $movement->setTotalCost(($movement->getMaterials()->getPurchasePrice()) * ($movement->getQuantity()));
            }
            if ($movement->getTools() != null) {

                $movement->setCommercialValue($movement->getTools()->getPrice() * $movement->getQuantity());
                $movement->setTotalCost($movement->getTools()->getPrice() * $movement->getQuantity());
            }
            if ($movement->getCables() != null) {
                $movement->setCommercialValue($movement->getCables()->getSalePrice() * $movement->getQuantity());
                $movement->setTotalCost($movement->getCables()->getPurchasePrice() * $movement->getQuantity());
            }
            $this->getDoctrine()->getManager()->flush();
        }
    }

}
