<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TutorielController extends DefaultController{

    /**
     * @Route("/tutoriel", name="tutoriel")
     */

    public function tutorielAction(){
        return $this->render('@App/Default/tutoriel.html.twig');
    }

}