<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\LoginUserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Form\ProfileUserType;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use App\Form\EditUserType;

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
    
    /**
     * @Route("/admin/user", name="all_user")
     */
    public function users(UserRepository $userRepository) {
        $users = $userRepository->findAll();
        return $this->render('security/user.html.twig', [
                    'users' => $users,
        ]);
    }
    
    
    /**
   * @Route("admin/user/remove/{id}", name="removeuser_id")
   * @ParamConverter("user", options={"mapping"={"id"="id"}})
   */
    
     public function UserRemove(User $user)
    {
                $em = $this->getDoctrine()->getEntityManager();
                $em->remove($user);
                $em->flush();
                $this->addFlash('notice', 'Conference supprimer');
                return $this->redirectToRoute('all_user');
    }
    
 /**
* @Route("/profile", name="profile")
*/
public function profile(Request $request, EntityManagerInterface $entityManager, LoggerInterface $logger)
{
$user = $this->getUser();
$form = $this->createForm(ProfileUserType::class, $user);
$logger->info('User edited now !');
$form->handleRequest($request);
if ($form->isSubmitted() && $form->isValid()) {
$entityManager->persist($user);
$entityManager->flush();
return $this->redirectToRoute('profile');
}
return $this->render('security/profile.html.twig', [
'form' => $form->createView()
]);
}

     /**
    * @Route("/admin/user/{user_id}", requirements={"id"=".+"}, name="edit_user")
    * @ParamConverter("user", options={"id" = "user_id"})
    */
    
     public function EditUser(User $user, Request $request)
    {
            $conf = $user;
            $form = $this->createForm(EditUserType::class, $conf);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($conf);
                $entityManager->flush();
                $this->addFlash('notice', 'User modifier');
                return $this->redirectToRoute('all_user'); 
            } 
     
        return $this->render('security/edituser.html.twig', [
            'form' => $form->createView(),
        ]);
         
    }
}
