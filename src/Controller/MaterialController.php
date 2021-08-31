<?php

namespace App\Controller;

use App\Entity\Material;
use App\Form\MaterialType;
use App\Repository\MaterialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/material")
 */
class MaterialController extends AbstractController
{
    /**
     * @Route("/", name="material_index", methods={"GET"})
     */
    public function index(MaterialRepository $materialRepository): Response
    {
        return $this->render('material/index.html.twig', [
            'materials' => $materialRepository->findBy([], ['name' => 'ASC'])
        ]);
    }

    /**
     * @Route("/new", name="material_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $material = new Material();
        $form = $this->createForm(MaterialType::class, $material);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($material);
            $entityManager->flush();

            return $this->redirectToRoute('material_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('material/new.html.twig', [
            'material' => $material,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="material_show", methods={"GET"})
     */
    public function show(Material $material): Response
    {
        return $this->render('material/show.html.twig', [
            'material' => $material,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="material_edit", methods={"GET","POST"})
     */
    public function edit(
        int $id,
        Request $request
    ): Response
    {
        $em = $this->getDoctrine()->getRepository(Material::class);
        $material = $em->find($id);
        $oldStock = $material->getStock();
        $material->setStock(0);
        $form = $this->createForm(MaterialType::class, $material);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $material->setStock($oldStock+$material->getStock());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('material_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('material/edit.html.twig', [
            'material' => $material,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="material_delete", methods={"POST"})
     */
    public function delete(
        Request $request,
        Material $material
    ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$material->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($material);
            $entityManager->flush();
        }

        return $this->redirectToRoute('material_index', [], Response::HTTP_SEE_OTHER);
    }
}
