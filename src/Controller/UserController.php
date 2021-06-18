<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/connexion", name="connexion", methods="GET|POST")
     */
    public function connexion(Request $req, EntityManagerInterface $em)
    {

    }
 
    /**
     * @Route("/user/create", name="user_create", methods="GET|POST")
     */
    public function create(Request $req, EntityManagerInterface $em): Response
    {
        $user = new User;

        $form = $this->createFormBuilder($user)
            ->add('name', TextType::class, ['label' => "Nom d'utilisateur"] )
            ->add('description', TextareaType::class, ['label' => 'Description'])
            ->add('city', TextType::class, ['label' => 'Ville'])
            //->add('zipcode', IntegerType::class, ['label' => 'Code postale'])
            ->add('email', EmailType::class,['attr' => ['class'=> 'form-label']])
            ->add('pswd', PasswordType::class, ['label' => 'Mot de passe'], ['attr' => ['class'=> 'form-label']])
            ->getForm()
        ;

        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $pswd = $user->getPassword();
            $hash = password_hash($pswd, PASSWORD_DEFAULT);
            $user->setPswd($hash);

            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Compte créé avec succès');

            return $this->redirectToRoute('user_connexion');
        }

        return $this->render('user/create.html.twig', [
            'addUser' => $form->createView()
        ]);
    }
     
    /**
     * @Route("/user/{id<[0-9]+>}", name="user_show")
     */
    public function show(int $id, UserRepository $repo, CommentRepository $repository): Response 
    {
        $user = $repo->find($id);
        $comments = $repository->findAll();

        if(!$user) {
            return $this->render('/user/error.html.twig');
        }
        
        return $this->render('/user/profile.html.twig', [
            'user' => $user,
            'comments' => $comments
        ]);
    }

}
