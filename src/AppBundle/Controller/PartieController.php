<?php

namespace AppBundle\Controller;

use AppBundle\Entity\stuff_me_user;
use AppBundle\Entity\stuff_me_partie;
use AppBundle\Entity\stuff_me_cartes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class PartieController extends Controller
{
    //Afficher les parties
    /**
     * @Route ("/parties/", name="mesparties")
     */

    public function mespartiesAction(){
        $user = $this->getUser();
        return $this->render('@App/Default/mesparties.html.twig', ['user' => $user]);
    }


    //Liste des users pour créer les parties
    /**
     * @Route("/parties/add", name="jouer")
     */
    public function addPartieAction()
    {
        $user = $this->getUser();
        // récupérer tous les joueurs existants
        $joueurs = $this->getDoctrine()->getRepository('AppBundle:stuff_me_user')->findAll();
        return $this->render("@App/Default/addpartie.html.twig", ['user' => $user, 'joueurs' => $joueurs]);
    }

    //Creation de la partie
    /**
     * @param stuff_me_user $id
     * @Route("/inviter/{joueur}", name="creer_partie")
     */
    public function creerPartieAction(stuff_me_user $joueur)
    {
        $user = $this->getUser();
        $partie = new stuff_me_partie();
        $partie->setJoueur1($user);
        $partie->setJoueur2($joueur);
        $em = $this->getDoctrine()->getManager();
        $em->persist($partie);
        $em->flush();
        // récupérer les cartes
        $modeles = $this->getDoctrine()->getRepository('AppBundle:stuff_me_cocktail')->findAll();
        //on mélange les cartes
        shuffle($modeles);
        for($i = 0; $i<8; $i++)
        {
            $cartes = new stuff_me_cartes();
            $cartes->setParties($partie);
            $cartes->setModeles($modeles[$i]);
            $cartes->setCarteSituation('mainJ1');
            $em->persist($cartes);
        }
        for($i = 8; $i<16; $i++)
        {
            $cartes = new stuff_me_cartes();
            $cartes->setParties($partie);
            $cartes->setModeles($modeles[$i]);
            $cartes->setCarteSituation('mainJ2');
            $em->persist($cartes);
        }
        for($i = 16; $i<count($modeles); $i++)
        {
            $cartes = new stuff_me_cartes();
            $cartes->setParties($partie);
            $cartes->setModeles($modeles[$i]);
            $cartes->setCarteSituation('pioche');
            $em->persist($cartes);
        }
        $em->flush();
        return $this->render('@App/Default/partie.html.twig', ['partie' => $partie, 'user' => $user]);
    }
}