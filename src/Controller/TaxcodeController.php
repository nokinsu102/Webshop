<?php

namespace App\Controller;

use App\Entity\Taxcode;
use App\Form\TaxcodeType;
use App\Repository\TaxcodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/taxcode")
 */
class TaxcodeController extends AbstractController
{
    /**
     * @Route("/", name="taxcode_index", methods={"GET"})
     */
    public function index(TaxcodeRepository $taxcodeRepository): Response
    {
        return $this->render('taxcode/index.html.twig', [
            'taxcodes' => $taxcodeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="taxcode_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $taxcode = new Taxcode();
        $form = $this->createForm(TaxcodeType::class, $taxcode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($taxcode);
            $entityManager->flush();

            return $this->redirectToRoute('taxcode_index');
        }

        return $this->render('taxcode/new.html.twig', [
            'taxcode' => $taxcode,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="taxcode_show", methods={"GET"})
     */
    public function show(Taxcode $taxcode): Response
    {
        return $this->render('taxcode/show.html.twig', [
            'taxcode' => $taxcode,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="taxcode_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Taxcode $taxcode): Response
    {
        $form = $this->createForm(TaxcodeType::class, $taxcode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('taxcode_index');
        }

        return $this->render('taxcode/edit.html.twig', [
            'taxcode' => $taxcode,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="taxcode_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Taxcode $taxcode): Response
    {
        if ($this->isCsrfTokenValid('delete'.$taxcode->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($taxcode);
            $entityManager->flush();
        }

        return $this->redirectToRoute('taxcode_index');
    }
}
