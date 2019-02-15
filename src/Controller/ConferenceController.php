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

class ConferenceController extends AbstractController {

    /**
     * @Route("/admin/conference", name="conference")
     */
    public function index(ConferenceRepository $conferenceRepository) {

        $infosConf = $conferenceRepository->findAll();
        return $this->render('conference/index.html.twig', [
                    'allConf' => $infosConf,
        ]);
    }

    /**
     * @Route("/admin/ajout-conference", name="ajout conference")
     */
    public function addConference(Request $request, MailController $mailController, UserRepository $userRepository) {
        $conf = new Conference();
        $form = $this->createForm(ConferenceType::class, $conf);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($conf);
            $entityManager->flush();
            $users = $userRepository->findAll();
            foreach ($users as $user) {
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
    public function confModif(Conference $conference, Request $request) {
        $conf = $conference;
        $form = $this->createForm(ConferenceType::class, $conf);

//        $form->get('date')->setData($conf->getDate("y-m-d"));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($conf);
            $entityManager->flush();
            $this->addFlash('notice', 'Conference modifier');
            return $this->redirectToRoute('conference');
        }

        return $this->render('conference/ajoutConf.html.twig', [
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/conf-remove/{conference_id}", requirements={"id"=".+"}, name="conf_remove")
     * @ParamConverter("conference", options={"id" = "conference_id"})
     */
    public function confRemove(Conference $conference) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($conference);
        $em->flush();
        $this->addFlash('notice', 'Conference supprimer');
        return $this->redirectToRoute('conference');
    }

    /**
     * @Route("/conference/{id}", name="conference_id")
     */
    public function detail(conference $id) {
        return $this->render('conference/id.html.twig', array(
                    'conference' => $id,
        ));
    }

    /**
     * @Route("/admin/confInfos/{conference_id}", requirements={"id"=".+"}, name="conf_infos")
     * @ParamConverter("conference", options={"id" = "conference_id"})
     */
    public function confInfos(ConferenceRepository $ConferenceRepository, Conference $conference, Request $request) {
        $conf = $conference;
        return $this->render('conference/infosConf.html.twig', [
                    'infosConf' => $conf
        ]);
    }
    
     /**
     * @Route("/voted", name="conference_top")
     */
    public function topConf(ConferenceRepository $conferenceRepository) {

        $infosConf = $conferenceRepository->findAll();
        return $this->render('conference/topConf.html.twig', [
                    'allConf' => $infosConf,
        ]);
    }
    
     /**
     * @Route("/unvoted", name="conference_unvoted")
     */
    public function unvotedConf(ConferenceRepository $conferenceRepository) {

        $infosConf = $conferenceRepository->findAll();
        return $this->render('conference/unvotedConf.html.twig', [
                    'allConf' => $infosConf,
        ]);
    }

}
