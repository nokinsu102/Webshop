<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\InvoiceProduct;
use App\Entity\User;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class CartController extends AbstractController
{

    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/cart", name="cart")
     */
    public function index()
    {
        $getCart = $this->session->get('cart', []);
        $this->session->get('cart', $getCart);

        return $this->render('cart/index.html.twig', [
            'cart' => $getCart
        ]);
    }

    /**
     * @Route("/checkout", name="checkout", methods={"GET", "POST"})
     */
    public function checkout(Product $product)
    {
        $session = $this->get('request_stack')->getCurrentRequest()->getSession();
        $getCart = $session->get('cart', []);
        // $products = $getCart[$product->getId()]['id'];
        $amount = $getCart[$product->getId()]['amount'];
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $invoice = new Invoice();
        $invoice->setDate(new \DateTime());
        $invoice->setPaid(true);
        $invoice->setPaidDate(new \DateTime());
        $invoice->setUser($user);

        foreach ($getCart as $id => $amount) {
            $row = new Row();
            $row->setInvoice($invoice);

            $em = $this->getDoctrine()->getManager();
            $product = $em->getRepository(Product::class)->find($id);

            $row->setAmount($amount);
            $row->setProduct($product);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($row);
            $entityManager->flush();
        }

        $session->clear();
        return $this->redirectToRoute('checkout');
    }

}
