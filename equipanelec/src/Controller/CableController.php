<?php

namespace App\Controller;

use App\Entity\Cable;
use App\Form\CableType;
use App\Repository\CableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cable")
 */
class CableController extends AbstractController
{
    /**
     * @Route("/", name="cable_index", methods={"GET"})
     */
    public function index(CableRepository $cableRepository): Response
    {
        if($this->isGranted("ROLE_MANAGER")||$this->isGranted("ROLE_CELLAR")){
            return $this->render('cable/index.html.twig', [
                'cables' => $cableRepository->findBy([], ['name' => 'ASC'])
            ]);
        }else{
            return $this->redirectToRoute('homepage', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/new", name="cable_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $cable = new Cable();
        $form = $this->createForm(CableType::class, $cable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cable);
            $entityManager->flush();

            return $this->redirectToRoute('cable_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cable/new.html.twig', [
            'cable' => $cable,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="cable_show", methods={"GET"})
     */
    public function show(Cable $cable): Response
    {
        return $this->render('cable/show.html.twig', [
            'cable' => $cable,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cable_edit", methods={"GET","POST"})
     */
    public function edit(
        int $id,
        Request $request
    ): Response
    {
        $em = $this->getDoctrine()->getRepository(Cable::class);
        $cable = $em->find($id);
        $oldAvailability = $cable->getAvailability();
        $cable->setAvailability(0);

        $form = $this->createForm(CableType::class, $cable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cable->setAvailability($oldAvailability+$cable->getAvailability());
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('cable_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cable/edit.html.twig', [
            'cable' => $cable,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="cable_delete", methods={"POST"})
     */
    public function delete(
        Request $request,
        Cable $cable
    ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cable->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cable);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cable_index', [], Response::HTTP_SEE_OTHER);
    }
}
