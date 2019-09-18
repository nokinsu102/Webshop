<?php

namespace App\Controller;

use App\Entity\Row;
use App\Form\RowType;
use App\Repository\RowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/row")
 */
class RowController extends AbstractController
{
    /**
     * @Route("/", name="row_index", methods={"GET"})
     */
    public function index(RowRepository $rowRepository): Response
    {
        return $this->render('row/index.html.twig', [
            'rows' => $rowRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="row_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $row = new Row();
        $form = $this->createForm(RowType::class, $row);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($row);
            $entityManager->flush();

            return $this->redirectToRoute('row_index');
        }

        return $this->render('row/new.html.twig', [
            'row' => $row,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="row_show", methods={"GET"})
     */
    public function show(Row $row): Response
    {
        return $this->render('row/show.html.twig', [
            'row' => $row,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="row_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Row $row): Response
    {
        $form = $this->createForm(RowType::class, $row);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('row_index', [
                'id' => $row->getId(),
            ]);
        }

        return $this->render('row/edit.html.twig', [
            'row' => $row,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="row_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Row $row): Response
    {
        if ($this->isCsrfTokenValid('delete'.$row->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($row);
            $entityManager->flush();
        }

        return $this->redirectToRoute('row_index');
    }
}
