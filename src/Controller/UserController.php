<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Product;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user/{id<[0-9]+>}", name="user_show")
     */
    public function show(int $id): Response 
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        if(!$user) {
            throw $this->createNotFoundException('No user found for id '.$id);
        }
        
        return $this->render('/user/profile.html.twig', ['user' => $user]);
    }

    public function getUserByEmail($email){
    
        //verification si le compte existe déjà
            $query = $this->bdd->prepare("SELECT * FROM user WHERE Mail =?");
            $query->execute(array($email));
            $result=$query->fetch();
            return $result;
      }

    /**
     * @Route("/user/connect", name="user_connection")
     */
    public function connect()
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
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('pages');
        }
        return $this->render('user/create.html.twig', [
            'addUser' => $form->createView()
        ]);
    }
}
