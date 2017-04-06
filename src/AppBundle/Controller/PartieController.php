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

    /**
     * @param stuff_me_partie $id
     * @Route("/afficher/{id}", name="afficherpartie")
     */
    public function afficherPartieAction(stuff_me_partie $id)
    {
        $cartes = $this->getDoctrine()->getRepository('AppBundle:stuff_me_cartes')->findAll();
        $partie = $this->getDoctrine()->getRepository('AppBundle:stuff_me_partie')->findBy(['id' => $id]);
        $user = $this->getUser();
        return $this->render('@App/Default/afficherpartie.html.twig', ['cartes' => $cartes, 'parties' => $partie, 'user' => $user]);
    }

    //Gestion de création de partie
    /**
     * @Route("/parties/add", name="jouer")
     */
    public function addPartieAction()
    {
        $user = $this->getUser();
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
        $partie->setPartieTour($user);
        $partie->setPartieJoueur1Score(0);
        $partie->setPartieJoueur2Score(0);
        //Si le joueur n'as jamais jouer, set win et loose à 0
        if (is_null($user->getWin())) {
            $user->setWin(0);
            $user->setLoose(0);
            $user->setTotaleScore(0);
        }
        if (is_null($joueur->getWin())) {
            $joueur->setWin(0);
            $joueur->setLoose(0);
            $joueur->setTotaleScore(0);
        }
        //Distribution des cartes
        $em = $this->getDoctrine()->getManager();
        $em->persist($partie);
        $em->flush();
        $cocktails = $this->getDoctrine()->getRepository('AppBundle:stuff_me_cocktail')->findAll();
        //mélange des cartes
        shuffle($cocktails);
        for($i = 0; $i<8; $i++)
        {
            $cartes = new stuff_me_cartes();
            $cartes->setParties($partie);
            $cartes->setModeles($cocktails[$i]);
            $cartes->setCarteSituation('mainJ1');
            $em->persist($cartes);
        }
        for($i = 8; $i<16; $i++)
        {
            $cartes = new stuff_me_cartes();
            $cartes->setParties($partie);
            $cartes->setModeles($cocktails[$i]);
            $cartes->setCarteSituation('mainJ2');
            $em->persist($cartes);
        }
        for($i = 16; $i<count($cocktails); $i++)
        {
            $cartes = new stuff_me_cartes();
            $cartes->setParties($partie);
            $cartes->setModeles($cocktails[$i]);
            $cartes->setCarteSituation('pioche');
            $em->persist($cartes);
        }
        $em->flush();
        return $this->render('@App/Default/partiecreer.html.twig', ['partie' => $partie, 'user' => $user]);
    }

    /**
     * @param stuff_me_partie $partieid
     * @Route("/piocherj1/{partieid}", name="piocherj1")
     */
    public function piocherj1Action($partieid)
    {
        $cartesPioche = $this->getDoctrine()->getRepository('AppBundle:stuff_me_cartes')->findOneBy(['carteSituation' => 'pioche', 'parties' => $partieid]);
        $em = $this->getDoctrine()->getManager();
        $cartesPioche->setCarteSituation('mainJ1');
        $em->flush();
        return $this->redirectToRoute('afficherpartie', ['id' => $partieid]);
    }
    /**
     * @param stuff_me_partie $partieid
     * @Route("/piocherj2/{partieid}", name="piocherj2")
     */
    public function piocherj2Action($partieid)
    {
        $cartesPioche = $this->getDoctrine()->getRepository('AppBundle:stuff_me_cartes')->findOneBy(['carteSituation' => 'pioche', 'parties' => $partieid]);
        $em = $this->getDoctrine()->getManager();
        $cartesPioche->setCarteSituation('mainJ2');
        $em->flush();
        return $this->redirectToRoute('afficherpartie', ['id' => $partieid]);
    }

    /**
     * @param stuff_me_partie $partieid
     * @Route ("/changetour/{partieid}", name="changetour")
     */
    public function changetourAction($partieid)
    {
        $tour = $this->getDoctrine()->getRepository('AppBundle:stuff_me_partie')->findOneBy(['id' => $partieid]);
        $em = $this->getDoctrine()->getManager();
        if ($tour->getPartieTour() == $tour->getJoueur1()){
         $tour->setPartieTour($tour->getJoueur2());
        }
        elseif ($tour->getPartieTour() == $tour->getJoueur2()){
            $tour->setPartieTour($tour->getJoueur1());
        }
        $em->flush();
        return $this->redirectToRoute('afficherpartie', ['id' => $partieid]);
    }

}