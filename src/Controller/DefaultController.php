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
    
    /**
     * @Route("/service/list-conf/{page}", name="ajax-list-conf")
     */
    public function ajaxListConf(ConferenceRepository $conferenceRepository, int $page){
        
        $dateDispo = $conferenceRepository->getAvaiableDates($page);
        $arrayConf = array();
        foreach($dateDispo as $key => $date){
            $arrayConf[$key] = $conferenceRepository->getConferenceForADay($date['date']);
        }
        
        if(count($arrayConf) == 0){
            die('-1');
        }
        
        return $this->render('default/list-conf-ajax.html.twig', ['confs' => $arrayConf]);
                
    }
    
    

}
