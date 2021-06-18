<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderLine;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index(SessionInterface $session, ProductRepository $repo, EntityManagerInterface $em, Request $request): Response
    {
        $cart = $session->get('cart',[]);

        $cartData = [];

        foreach($cart as $id => $quantity){
            $cartData[] = [
                'product' => $repo->find($id),
                'quantity' => $quantity
            ];

        }

        $total = 0;
        foreach($cartData as $item){
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }
        
        return $this->render('cart/index.html.twig', [
            'items' => $cartData,
            'total' => $total
        ]);
    }

    /**
     * @Route("/cart/add/{id<[0-9]+>}", name="cart_add", methods="GET|POST")
     */
    public function add(int $id, SessionInterface $session, ProductRepository $repo)
    {
        $product = $repo->find($id);
        /*if (!($session->has('cart'))) {
            return $this->redirectToRoute('cart');
        }*/
        $cart = $session->get('cart', []);

        if(!empty($cart[$id])){
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
        $session->set('cart', $cart);

        return $this->redirectToRoute('cart');


    }

    /**
     * @Route("/cart/remove/{id<[0-9]+>}", name="cart_remove", methods="GET|POST")
     */
    public function remove(int $id, SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);

        if(!empty($cart[$id])){
            unset($cart[$id]);
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/validation", name="cart_validation", methods="GET|POST")
     */
    public function validation(SessionInterface $session)
    {
        $session->set('cart', []);
        $this->addFlash('success', 'Panier validé');

        return $this->redirectToRoute("add_comment");
    }


}
