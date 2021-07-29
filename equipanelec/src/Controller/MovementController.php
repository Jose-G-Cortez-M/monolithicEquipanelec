<?php

namespace App\Controller;

use App\Entity\Movement;
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
     * @Route("/new", name="movement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $movement = new Movement();
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
