<?php

namespace App\Controller;

use App\Entity\Cable;
use App\Entity\Material;
use App\Entity\Movement;
use App\Entity\Tool;
use App\Form\MovementType;
use App\Repository\MovementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/newmaterial/{id}", name="movement_new_material", methods={"GET","POST"})
     */
    public function newmaterial(Request $request,$id): Response
    {
        $mensaje = "";
        $movement = new Movement();
        $material = new Material();
        $em = $this->getDoctrine()->getRepository(Material::class);
        $material = $em->find($id);
        $movement->setMaterials($material);

        $form = $this->createForm(MovementType::class, $movement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($movement->getMaterials()->getStock()>=$movement->getQuantity())
            {
                $restante = ($movement->getMaterials()->getStock())-($movement->getQuantity());
                $material->setStock($restante);
                $movement->setMaterials($material);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($movement);
                $entityManager->flush();
                return $this->redirectToRoute('movement_index', [], Response::HTTP_SEE_OTHER);
            }else{
                echo $mensaje = "<h2>Opss! No tienes suficientes materiales en bodega :P</h2>";
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
    public function newcable(Request $request,$id): Response
    {
        $movement = new Movement();

        $cable = new Cable();
        $em = $this->getDoctrine()->getRepository(Cable::class);
        $cable = $em->find($id);
        $movement->setCables($cable);


        $form = $this->createForm(MovementType::class, $movement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($movement);
            $entityManager->flush();

            return $this->redirectToRoute('movement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('movement/new.html.twig', [
            'movement' => $movement,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/newtool/{id}", name="movement_new_tool", methods={"GET","POST"})
     */
    public function newtool(Request $request,$id): Response
    {
        $movement = new Movement();

        $tool = new Tool();
        $em = $this->getDoctrine()->getRepository(Tool::class);
        $tool = $em->find($id);
        $movement->setTools($tool);


        $form = $this->createForm(MovementType::class, $movement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($movement);
            $entityManager->flush();

            return $this->redirectToRoute('movement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('movement/new.html.twig', [
            'movement' => $movement,
            'form' => $form,
        ]);
    }




    /**
     * @Route("/{id}", name="movement_show", methods={"GET"})
     */
    public function show(Movement $movement): Response
    {
        return $this->render('movement/show.html.twig', [
            'movement' => $movement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="movement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Movement $movement): Response
    {
        $form = $this->createForm(MovementType::class, $movement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('movement_index', [], Response::HTTP_SEE_OTHER);
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

        return $this->redirectToRoute('movement_index', [], Response::HTTP_SEE_OTHER);
    }
}
