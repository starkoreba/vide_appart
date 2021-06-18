<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/comment/add", name="add_comment")
     */
    public function addComment(Request $req, EntityManagerInterface $em): Response
    {
        $com = new Comment;
        $form = $this->createFormBuilder($com)
            ->add('pseudo')
            ->add('title')
            ->add('content', TextareaType::class)
            ->getForm()
        ;

        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($com);
            $em->flush();
            $this->addFlash('success', 'Votre commentaire à bien été enregistré');
            
            return $this->redirectToRoute('user_show', ['id' => 1]);
        }

        return $this->render('pages/addcomment.html.twig', [
            'addCom' => $form->createView()
        ]);
    }

    
}
