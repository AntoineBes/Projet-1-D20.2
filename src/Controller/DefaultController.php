<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ConferenceRepository;

class DefaultController extends AbstractController {

    /**
     * @Route("/", name="home")
     */
    public function index(ConferenceRepository $conferenceRepository) {
        $confHomepage = $conferenceRepository->findBy(array(), array('id' => 'desc'), 3, null);
        
        return $this->render('default/index.html.twig', ['firstConf' => $confHomepage]);
    }

}
