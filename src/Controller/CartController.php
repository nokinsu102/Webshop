<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Entity\Product;
use App\Entity\Row;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;


class CartController extends AbstractController
{

    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/cart/", name="cart")
     */
    public function display(){
        $cart = $this->session->get('cart', []);

        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
        ]);
    }

    /**
     * @Route("/checkout/", name="checkout")
     */
    public function checkout()
    {
        $cart = $this->session->get('cart', []);
        $total = 0;
         foreach($cart as $id => $details)
         {
             $total = $total + ($cart[$id]['amount'] * $cart[$id]['price']);
         }

         $this->session->set('total', $total);
        $entityManager = $this->getDoctrine()->getManager();

        $invoice = new Invoice();
        $invoice->setDate(new \DateTime());
        $invoice->setPaidDate(new \DateTime());
        $invoice->setPaid(true);
        $invoice->setUser($this->getUser());
        $invoice->setTotal($total);

        foreach ($cart as $id => $quantity) 
        {
            $row = new Row();
            $row->setInvoice($invoice);
            $row->setQuantity($quantity['amount']);
            $product = $this->getDoctrine()->getManager()->getRepository(Product::class)->find($id);
            $row->setProduct($product);
            $em = $this->getDoctrine()->getManager();
            $em->persist($row);
            $em->flush();
        }

        $entityManager->persist($invoice);
        $this->session->clear();
        return $this->redirectToRoute('invoice_index', [

        ]);
    }

}
