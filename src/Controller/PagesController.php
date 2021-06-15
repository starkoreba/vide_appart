<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PagesController extends AbstractController
{
    
    /**
     * @Route("/", name="pages")
     */
    public function index(ProductRepository $repo, UserRepository $repos): Response
    {
        $products = $repo->findAll();
        $user = $repos->find(1);

        return $this->render('pages/index.html.twig', compact('products', 'user'));
    }

    
}
