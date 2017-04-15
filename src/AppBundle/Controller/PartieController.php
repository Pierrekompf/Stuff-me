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
        $partie = $this->getDoctrine()->getRepository('AppBundle:stuff_me_partie')->find($partieid);
        $em = $this->getDoctrine()->getManager();
        $cartesPioche->setCarteSituation('mainJ1');
        if ($partie->getPartieTour() == $partie->getJoueur1()) {
            $partie->setPartieTour($partie->getJoueur2());
        } else {
            $partie->setPartieTour($partie->getJoueur1());
        }
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
        $partie = $this->getDoctrine()->getRepository('AppBundle:stuff_me_partie')->find($partieid);
        $em = $this->getDoctrine()->getManager();
        $cartesPioche->setCarteSituation('mainJ2');
        if ($partie->getPartieTour() == $partie->getJoueur1()) {
            $partie->setPartieTour($partie->getJoueur2());
        } else {
            $partie->setPartieTour($partie->getJoueur1());
        }
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

    /**
     * @param stuff_me_partie $partieid stuff_me_cartes $carteid
     * @Route("jouerJ1/{partieid}/{carteid}", name="jouerJ1")
     **/
    public function jouerCarteJ1Action($partieid, $carteid)
    {
        //recup de la carte à jouer, et de sa catégorie
        $carteAJouer = $this->getDoctrine()->getRepository('AppBundle:stuff_me_cartes')->findOneBy(['id' => $carteid]);
        $categorie = $carteAJouer->getModeles()->getCocktailCategorie();
        $valeur = $carteAJouer->getModeles()->getCocktailValeur();
        //recup des cartes sur le plateau
        $cartesSurPlateau = $this->getDoctrine()->getRepository('AppBundle:stuff_me_cartes')->findBy(['carteSituation' => 'plateauJ1', 'parties' => $partieid]);
        //si il y a des cartes sur le plateau
        if (!empty($cartesSurPlateau)) {
            $test = 0;
            $aEteJouee = 0;
            foreach ($cartesSurPlateau as $val) {
                //si les catégories sont les mêmes et que la valeur de la carte jouée est supérieure à celle du plateau
                if ($val->getModeles()->getCocktailCategorie() == $categorie) {
                    if ($val->getModeles()->getCocktailValeur() < $valeur) {
                        $aEteJouee = 1;
                    }
                } else {
                    //on incrémente si les catégories ne sont pas les mêmes
                    $test++;
                }
            }
            if ($test == count($cartesSurPlateau) || $aEteJouee == 1) {
                //on joue la carte
                $em = $this->getDoctrine()->getManager();
                $carteAJouer->setCarteSituation('plateauJ1');
                $em->flush();
            }
        } else {
            //sinon on joue la carte
            $em = $this->getDoctrine()->getManager();
            $carteAJouer->setCarteSituation('plateauJ1');
            $em->flush();
        }
        //TODO::faire une verification de fin de parite, et rediriger vers une fonction fin de partie
        return $this->redirectToRoute('afficherpartie', ['id' => $partieid]);
    }

    /**
     * @param stuff_me_partie $partieid stuff_me_cartes $carteid
     * @Route("/jouerJ2/{partieid}/{carteid}", name="jouerJ2")
     **/
    public function jouerCarteJ2Action($partieid, $carteid)
    {
        //recup de la carte à jouer, et de sa catégorie
        $carteAJouer = $this->getDoctrine()->getRepository('AppBundle:stuff_me_cartes')->findOneBy(['id' => $carteid]);
        $categorie = $carteAJouer->getModeles()->getCocktailCategorie();
        $valeur = $carteAJouer->getModeles()->getCocktailValeur();
        //recup des cartes sur le plateau
        $cartesSurPlateau = $this->getDoctrine()->getRepository('AppBundle:stuff_me_cartes')->findBy(['carteSituation' => 'plateauJ2', 'parties' => $partieid]);
        //si il y a des cartes sur le plateau
        if (!empty($cartesSurPlateau)) {
            $test = 0;
            $aEteJouee = 0;
            foreach ($cartesSurPlateau as $val) {
                //si les catégories sont les mêmes et que la valeur de la carte jouée est supérieure à celle du plateau
                if ($val->getModeles()->getCocktailCategorie() == $categorie) {
                    if ($val->getModeles()->getCocktailValeur() < $valeur) {
                        $aEteJouee = 1;
                    }
                } else {
                    //on incrémente si les catégories ne sont pas les mêmes
                    $test++;
                }
            }
            if ($test == count($cartesSurPlateau) || $aEteJouee == 1) {
                //on joue la carte
                $em = $this->getDoctrine()->getManager();
                $carteAJouer->setCarteSituation('plateauJ2');
                $em->flush();
            }
        } else {
            //sinon on joue la carte
            $em = $this->getDoctrine()->getManager();
            $carteAJouer->setCarteSituation('plateauJ2');
            $em->flush();
        }
        //TODO::faire une verification de fin de parite, et rediriger vers une fonction fin de partie
        return $this->redirectToRoute('afficherpartie', ['id' => $partieid]);
    }


}