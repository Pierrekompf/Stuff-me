<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="index")
     */

    public function indexAction() {
        $classement = $this->getDoctrine()->getManager()->getRepository('AppBundle:stuff_me_user')->findBy(
            array('nationalite' => 'FR'),
            array('totale_score' => 'desc'),
            5
        );

        $classementinter = $this->getDoctrine()->getManager()->getRepository('AppBundle:stuff_me_user')->findBy(
            array (),
            array('totale_score' => 'desc'),
            5
        );

        return $this->render("AppBundle:Default:index.html.twig", ['classement'=>$classement , 'classementinter'=>$classementinter]);
    }

}
