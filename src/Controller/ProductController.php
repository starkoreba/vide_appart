<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/{id<[0-9]+>}", name="product")
     */
    public function index(int $id, ProductRepository $repo): Response
    {
        $product = $repo->find($id);
        return $this->render('product/index.html.twig', [
            'product' => $product,
        ]);
    }
    
}
