<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Conference;
use App\Form\ConferenceType;
use App\Repository\ConferenceRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ConferenceController extends AbstractController
{
    /**
     * @Route("/admin/conference", name="conference")
     */
    public function index(ConferenceRepository $conferenceRepository)
    {
        
        $infosConf = $conferenceRepository->findAll();
        return $this->render('conference/index.html.twig', [
            'controller_name' => 'ConferenceController',
            'allConf' => $infosConf,
        ]);
    }
    
    /**
    * @Route("/admin/ajout-conference", name="ajout conference")
    */
    public function addConference(Request $request, MailController $mailController,UserRepository $userRepository)
    {
            $conf = new Conference();
            $form = $this->createForm(ConferenceType::class, $conf);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($conf);
                $entityManager->flush();
                $users = $userRepository->findAll();
                foreach ($users as $user){
                    $mailController->index($user);
                }
                $this->addFlash('notice', 'Conference crée');
                return $this->redirectToRoute('conference'); 
            } 
        return $this->render('conference/ajoutConf.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    
     /**
    * @Route("/admin/conf-edit/{conference_id}", requirements={"id"=".+"}, name="conf_modif")
    * @ParamConverter("conference", options={"id" = "conference_id"})
    */
    
     public function confModif( ConferenceRepository $ConferenceRepository,Conference $conference,Request $request)
    {
            $conf = $conference;
            $form = $this->createForm(ConferenceType::class, $conf);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($conf);
                $entityManager->flush();
                $this->addFlash('notice', 'Conference modifier');
                return $this->redirectToRoute('conference'); 
            } 
     
        return $this->render('conference/modifConf.html.twig', [
            'form' => $form->createView(),
        ]);
         
    }
    
     /**
    * @Route("/conf-remove/{conference_id}", requirements={"id"=".+"}, name="conf_remove")
    * @ParamConverter("conference", options={"id" = "conference_id"})
    */
    
     public function confRemove(ConferenceRepository $ConferenceRepository,Conference $conference,Request $request)
    {
                $em = $this->getDoctrine()->getEntityManager();
                $em->remove($conference);
                $em->flush();
                $this->addFlash('notice', 'Conference supprimer');
                return $this->redirectToRoute('conference');
    }
    
 
    
    
    
}
