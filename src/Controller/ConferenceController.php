<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Conference;
use App\Entity\Vote;
use App\Form\ConferenceType;
use App\Form\VoteType;
use App\Repository\ConferenceRepository;
use App\Repository\VoteRepository;
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
     * @Route("/admin/confInfos/{conference_id}", requirements={"id"=".+"}, name="conf_infos")
     * @ParamConverter("conference", options={"id" = "conference_id"})
     */
    public function confInfos(ConferenceRepository $ConferenceRepository, Conference $conference, Request $request, VoteRepository $voteRepository) {
        $user = $this->getUser();
        if ($user == null) {
            $this->addFlash('notice', 'Il faut être inscrit pour voir les conferences !');
            return $this->redirectToRoute('login');
        }
        $conf = $conference;
        $user = $this->getUser();
        $form = $this->createForm(VoteType::class);
        $form->handleRequest($request);
        $voteUser = $voteRepository->findBy(array('user_id' => $user->getId(), 'conf_id' => $conf->getId()));
        if ($voteUser != null) {
            if ($form->isSubmitted() && $form->isValid()) {
                $vote = $voteUser[0];
                $voteEntity = $vote;
                $note = $form->getData()->getNote();
                $voteEntity->setConfId($conf);
                $voteEntity->setUserId($user);
                $voteEntity->setNote($note);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($voteEntity);
                $entityManager->flush();
                $this->addFlash('notice', 'Conference modifier');
            } else {
                $form->get('note')->setData($voteUser[0]->getNote());
            }
            return $this->render('conference/infosConf.html.twig', [
                        'infosConf' => $conf,
                        'form' => $form->createView(),
            ]);
        } else {
            if ($form->isSubmitted() && $form->isValid()) {
                $note = $form->getData()->getNote();
                $voteEntity = new Vote();
                $voteEntity->setConfId($conf);
                $voteEntity->setUserId($user);
                $voteEntity->setNote($note);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($voteEntity);
                $entityManager->flush();
                $this->addFlash('notice', 'Conference modifier');
            }
            return $this->render('conference/infosConf.html.twig', [
                        'infosConf' => $conf,
                        'form' => $form->createView(),
            ]);
        }
    }

    /**
     * @Route("/conference/{id}", requirements={"id"=".+"}, name="conference_id")
     * @ParamConverter("conference", options={"id" = "id"})
     */
    public function confInfoss(ConferenceRepository $ConferenceRepository, Conference $conference, Request $request, VoteRepository $voteRepository) {
        $user = $this->getUser();
        if ($user == null) {
            $this->addFlash('notice', 'Il faut être inscrit pour voir les conferences !');
            return $this->redirectToRoute('login');
        }
        $conf = $conference;
        $user = $this->getUser();
        $form = $this->createForm(VoteType::class);
        $form->handleRequest($request);
        $voteUser = $voteRepository->findBy(array('user_id' => $user->getId(), 'conf_id' => $conf->getId()));
        if ($voteUser != null) {
            if ($form->isSubmitted() && $form->isValid()) {
                $vote = $voteUser[0];
                $voteEntity = $vote;
                $note = $form->getData()->getNote();
                $voteEntity->setConfId($conf);
                $voteEntity->setUserId($user);
                $voteEntity->setNote($note);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($voteEntity);
                $entityManager->flush();
                $this->addFlash('notice', 'Conference modifier');
            } else {
                $form->get('note')->setData($voteUser[0]->getNote());
            }
            return $this->render('conference/infosConf.html.twig', [
                        'infosConf' => $conf,
                        'form' => $form->createView(),
            ]);
        } else {
            if ($form->isSubmitted() && $form->isValid()) {
                $note = $form->getData()->getNote();
                $voteEntity = new Vote();
                $voteEntity->setConfId($conf);
                $voteEntity->setUserId($user);
                $voteEntity->setNote($note);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($voteEntity);
                $entityManager->flush();
                $this->addFlash('notice', 'Conference modifier');
            }
            return $this->render('conference/infosConf.html.twig', [
                        'infosConf' => $conf,
                        'form' => $form->createView(),
            ]);
        }
    }

    /**
     * @Route("/voted", name="conference_top")
     */
    public function topConf(ConferenceRepository $conferenceRepository) {

        $topConf = $conferenceRepository->getTop10Conf();
    
        return $this->render('conference/topConf.html.twig', [
                    'allConf' => $topConf,
        ]);
    }

    /**
     * @Route("/unvoted", name="conference_unvoted")
     */
    public function unvotedConf(ConferenceRepository $conferenceRepository) {

        $unvotedConf = $conferenceRepository->getUnvotedConf();
        return $this->render('conference/unvotedConf.html.twig', [
                    'allConf' => $unvotedConf,
        ]);
    }

}
