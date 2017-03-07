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
        return $this->render("AppBundle:Default:index.html.twig");
    }

    /**
     * @Route("/en", name="index_en")
     */

    public function indexenAction() {
        return $this->render("AppBundle:Default:index_en.html.twig");
    }

    /**
     * @Route("/admin", name="admin")
     */

    public function adminAction(){
        return $this->render("AppBundle:Default:admin.html.twig");
    }

    /**
     * @Route("/admin_user", name="admin_user")
     */

    public function admin_userAction(){
        return $this->render("AppBundle:Default:admin_user.html.twig");
    }

    /**
     * @Route("/admin_jeu", name="admin_jeu")
     */

    public function admin_jeuAction(){
        return $this->render("AppBundle:Default:admin_jeu.html.twig");
    }
}
