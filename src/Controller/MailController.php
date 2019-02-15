<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class MailController extends AbstractController {

    private $mailler;
    
    public function __construct(\Swift_Mailer $mailer) {
        $this->mailler = $mailer;
    }

    /**
     * @Route("/mail", name="mail")
     */
    public function index(User $user) {
        $message = (new \Swift_Message('Nouvelle conférence en ligne a ne louper sous aucun pretexte !'))
                ->setFrom('conf2000@msn.com')
                ->setTo($user->getEmail())
                ->setBody(
                $this->renderView(
                        'mail/registration.html.twig', ['user' => $user]
                ), 'text/html'
                )
        /*
         * If you also want to include a plaintext version of the message
          ->addPart(
          $this->renderView(
          'emails/registration.txt.twig',
          ['name' => $name]
          ),
          'text/plain'
          )
         */
        ;

        $this->mailler->send($message);
    }

}
