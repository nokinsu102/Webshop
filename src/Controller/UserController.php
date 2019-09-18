<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Entity\Row;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(): Response
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }


    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * @Route("/profile/yourinvoices", name="user_your_invoices")
     */
    public function userInvoices(): Response
    {

        $id = $this->container->get('security.token_storage')->getToken()->getUser();

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id->getId());

        $invoice = $this->getDoctrine()
            ->getRepository(Invoice::class)
            ->findBy(['user' => $id->getId()]);

        return $this->render('user/your_invoices.html.twig', [
            'user' => $user,
            'invoice' => $invoice
        ]);
    }

    /**
     * @Route("/profile/yourinvoices/{id}/", name="user_see_invoice")
     */
    public function seeInvoiceAction($id){
        $invoice = $this->getDoctrine()
            ->getRepository(Invoice::class)
            ->findBy(['id' => $id]);

        $row = $this->getDoctrine()
            ->getRepository(Row::class)
            ->findBy(['invoice' => $id]);

        return $this->render('user/see_own_invoice.html.twig', [
            'invoice' => $invoice,
            'row' => $row
        ]);
    }
}
