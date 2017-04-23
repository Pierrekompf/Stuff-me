<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UniversController extends DefaultController{

    /**
     * @Route("/univers", name="univers")
     */

    public function universAction(){

        $cocktails = $this->getDoctrine()->getManager()->getRepository('AppBundle:stuff_me_cocktail')->findAll();

        return $this->render("AppBundle:Default:univers.html.twig", ['cocktailtous'=>$cocktails] );
    }

}