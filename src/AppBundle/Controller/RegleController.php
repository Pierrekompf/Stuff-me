<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegleController extends DefaultController{

    /**
     * @Route ("/regles", name="regles")
     */

    public function reglesAction(){
        return $this->render('@App/Default/regles.html.twig');
    }

}