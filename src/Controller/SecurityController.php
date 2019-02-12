<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\LoginUserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\UserType;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

//use App\Repository\UserRepository;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
//use App\Manager\UserManager;

class SecurityController extends AbstractController 
{

    /**
     * @Route("/security", name="security")
     */
    public function index() {
        return $this->render('security/index.html.twig', [
                    'controller_name' => 'SecurityController',
        ]);
    }

    /**
     * @Route("/subscribe", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface
    $passwordEncoder) {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('security/register.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils) {
        $user = new User();
        $form = $this->createForm(LoginUserType::class, $user);       
        
        if($authenticationUtils->getLastAuthenticationError() != null){
            $this->addFlash('danger', 'mot de passe non valide');
        }
        else{
//            $this->addFlash('success', 'Vous etes connectés');
        }
        
        return $this->render('security/login.html.twig', [
                    'error' => $authenticationUtils->getLastAuthenticationError(),
                    'form' => $form->createView()
        ]);
    }
    
}