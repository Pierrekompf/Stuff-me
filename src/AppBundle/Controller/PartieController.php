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
        $nbpioche = count($this->getDoctrine()->getRepository('AppBundle:stuff_me_cartes')->findBy(['carteSituation' => 'pioche' , 'parties' => $id]));
        $cartemaxbiere = count($this->getDoctrine()->getRepository('AppBundle:stuff_me_cartes')->findBy(['carteSituation' => 'defaussebiere', 'parties' => $id]));
        $cartemaxcognac = count($this->getDoctrine()->getRepository('AppBundle:stuff_me_cartes')->findBy(['carteSituation' => 'defaussecognac', 'parties' => $id]));
        $cartemaxtequila = count($this->getDoctrine()->getRepository('AppBundle:stuff_me_cartes')->findBy(['carteSituation' => 'defaussetequila', 'parties' => $id]));
        $cartemaxvodka = count($this->getDoctrine()->getRepository('AppBundle:stuff_me_cartes')->findBy(['carteSituation' => 'defaussevodka', 'parties' => $id]));
        $cartemaxrhum = count($this->getDoctrine()->getRepository('AppBundle:stuff_me_cartes')->findBy(['carteSituation' => 'defausserhum', 'parties' => $id]));
        $user = $this->getUser();
        return $this->render('@App/Default/afficherpartie.html.twig', ['cartes' => $cartes, 'parties' => $partie, 'user' => $user , 'nbpioche' => $nbpioche, 'cartemaxbiere' => $cartemaxbiere, 'cartemaxvodka' => $cartemaxvodka, 'cartemaxtequila' => $cartemaxtequila, 'cartemaxrhum' => $cartemaxrhum, 'cartemaxcognac' => $cartemaxcognac]);
    }

    /**
     * @Route("/parties/add", name="creation")
     */
    public function addPartieAction()
    {
        $user = $this->getUser();
        $joueurs = $this->getDoctrine()->getRepository('AppBundle:stuff_me_user')->findAll();
        return $this->render("@App/Default/addpartie.html.twig", ['user' => $user, 'joueurs' => $joueurs]);
    }

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
        $partie->setJ1cartejouer(0);
        $partie->setJ2cartejouer(0);
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
        //distribution
        $em = $this->getDoctrine()->getManager();
        $em->persist($partie);
        $em->flush();
        $cocktails = $this->getDoctrine()->getRepository('AppBundle:stuff_me_cocktail')->findAll();
        //mélange
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

    function changetour($partieid){
        $partie = $this->getDoctrine()->getRepository('AppBundle:stuff_me_partie')->find($partieid);
        $jouer = $this->getDoctrine()->getRepository('AppBundle:stuff_me_partie')->findOneBy(['id' => $partieid]);
        //changement de tour
        if ($partie->getPartieTour() == $partie->getJoueur1()) {
            $partie->setPartieTour($partie->getJoueur2());
        } else {
            $partie->setPartieTour($partie->getJoueur1());
        }
        //remise a zéro des cartes jouer
        $jouer->setJ1cartejouer('0');
        $jouer->setJ2cartejouer('0');
    }

    function finpartie($partieid){
        $partie = $this->getDoctrine()->getRepository('AppBundle:stuff_me_partie')->find($partieid);
        $joueur2 = $partie->getJoueur2();
        $joueur1 = $partie->getJoueur1();
        $cartes = $this->getDoctrine()->getRepository('AppBundle:stuff_me_cartes')->findBy(['parties' => $partieid]);
        $cartesPioche = $this->getDoctrine()->getRepository('AppBundle:stuff_me_cartes')->findBy(['carteSituation' => 'pioche', 'parties' => $partieid]);
        $nbcartes = count($cartesPioche);
        $em = $this->getDoctrine()->getManager();
        if ( $nbcartes == 1 ){
            if ($partie->getPartieJoueur1Score() > $partie->getPartieJoueur2Score()){
                $partie->setGagnant($partie->getJoueur1());
                $joueur1->setTotaleScore( $joueur1->getTotaleScore() + 10);
                if ($joueur2->getTotaleScore() >= 5){
                    $joueur2->setTotaleScore( $joueur2->getTotaleScore() - 5);
                }
            } elseif ($partie->getPartieJoueur1Score() < $partie->getPartieJoueur2Score()) {
                $partie->setGagnant($partie->getJoueur2());
                if ($joueur1->getTotaleScore() >= 5) {
                    $joueur1->setTotaleScore($joueur1->getTotaleScore() - 5);
                }
                $joueur2->setTotaleScore( $joueur2->getTotaleScore() + 10);
            } else {
                $partie->setGagnant('Egalité');
                $joueur1->setTotaleScore($joueur1->getTotaleScore() + 5);
                $joueur2->setTotaleScore($joueur2->getTotaleScore() + 5);
            }
            foreach ($cartes as $carte) {
                $em->remove($carte);
                $em->flush();
            }
        }

    }


    /**
     * @param stuff_me_partie $partieid
     * @Route("/piocher/{partieid}", name="piocher")
     */
    public function piocherAction($partieid)
    {
        $cartesPioche = $this->getDoctrine()->getRepository('AppBundle:stuff_me_cartes')->findOneBy(['carteSituation' => 'pioche', 'parties' => $partieid]);
        $partie = $this->getDoctrine()->getRepository('AppBundle:stuff_me_partie')->find($partieid);
        $jouer = $this->getDoctrine()->getRepository('AppBundle:stuff_me_partie')->findOneBy(['id' => $partieid]);
        $em = $this->getDoctrine()->getManager();
        if ($partie->getPartieTour() == $partie->getJoueur1()) {
            $cartesPioche->setCarteSituation('mainJ1');
        } else {
            $cartesPioche->setCarteSituation('mainJ2');
        }
        $score= $this->changetour($partieid);
        $finpartie = $this->finpartie($partieid);
        $em->flush();
        return $this->redirectToRoute('afficherpartie', ['id' => $partieid]);
    }

    /**
     * @param stuff_me_partie $partieid stuff_me_cartes $carteid
     * @Route("/defausse/{partieid}/{carteid}", name="defausserCarte")
     */
    public function defausseAction($partieid, $carteid)
    {
        $partie = $this->getDoctrine()->getRepository('AppBundle:stuff_me_partie')->find($partieid);
        $cartedefausser = $this->getDoctrine()->getRepository('AppBundle:stuff_me_cartes')->findOneBy(['id' => $carteid]);
        $cartedefausse = $this->getDoctrine()->getRepository('AppBundle:stuff_me_cartes')->findBy(['carteSituation' => 'defausse'.$cartedefausser->getModeles()->getCocktailCategorie(), 'parties' => $partieid]);
        $em = $this->getDoctrine()->getManager();
        if (!empty($cartedefausse)) {
            $ordre = count($cartedefausse) + 1;
            $cartedefausser->setCarteSituation('defausse'.$cartedefausser->getModeles()->getCocktailCategorie());
            $cartedefausser->setCarteOrdre($ordre);
        } else {
            $cartedefausser->setCarteSituation('defausse'.$cartedefausser->getModeles()->getCocktailCategorie());
            $cartedefausser->setCarteOrdre(1);
        }
        $partie->setJ1cartejouer('1');
        $partie->setJ2cartejouer('1');
        $em->flush();
        return $this->redirectToRoute('afficherpartie', ['id' => $partieid ]);
    }

    /**
     * @param stuff_me_partie $partieid stuff_me_cartes $carteid
     * @Route("/recup/{partieid}/{carteid}", name="recup")
     */
    public function recupAction($partieid, $carteid)
    {
        $partie = $this->getDoctrine()->getRepository('AppBundle:stuff_me_partie')->find($partieid);
        $cartesrecup = $this->getDoctrine()->getRepository('AppBundle:stuff_me_cartes')->findOneBy(['id' => $carteid]);
        $em = $this->getDoctrine()->getManager();
        if ($partie->getPartieTour() == $partie->getJoueur1()) {
            $cartesrecup->setCarteSituation('mainJ1');
        } else {
            $cartesrecup->setCarteSituation('mainJ2');
        }
        $score= $this->changetour($partieid);
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
     * @Route("jouer/{partieid}/{carteid}", name="jouer")
     **/
    public function jouerCarteAction($partieid, $carteid)
    {
        $cartejouer = $this->getDoctrine()->getRepository('AppBundle:stuff_me_cartes')->findOneBy(['id' => $carteid]);
        $jouer = $this->getDoctrine()->getRepository('AppBundle:stuff_me_partie')->findOneBy(['id' => $partieid]);
        $categorie = $cartejouer->getModeles()->getCocktailCategorie();
        $valeur = $cartejouer->getModeles()->getCocktailValeur();
        if ($jouer->getPartieTour() == $jouer->getJoueur1()){
        $cartesplateau = $this->getDoctrine()->getRepository('AppBundle:stuff_me_cartes')->findBy(['carteSituation' => 'plateauJ1', 'parties' => $partieid]);
        $score = $jouer->getPartieJoueur1Score();

        if (!empty($cartesplateau)) {
            $remplis = 0;
            $etejouer = 0;
            foreach ($cartesplateau as $val) {
                if ($val->getModeles()->getCocktailCategorie() == $categorie) {
                    if ($val->getModeles()->getCocktailValeur() <= $valeur) {
                        $etejouer = 1;
                    }
                } else {
                    $remplis++;
                }
            }
            if ($remplis == count($cartesplateau) || $etejouer == 1) {
                $em = $this->getDoctrine()->getManager();
                $cartejouer->setCarteSituation('plateauJ1');
                $jouer->setJ1cartejouer('1');

                $multiplicateur = 1;
                if ($cartejouer->getModeles()->getCocktailExtra() == 1) {
                    $multiplicateur++;
                }
                foreach ($cartesplateau as $val) {
                    if ($val->getModeles()->getCocktailCategorie() == $categorie && $val->getModeles()->getCocktailExtra() == 1) {
                        if ($cartejouer->getModeles()->getCocktailExtra() == 1) {
                            $score += -20;
                        }
                        $multiplicateur++;
                    }
                }
                if ($remplis == count($cartesplateau)) {
                    $score += -20 * $multiplicateur;
                }
                $score += $cartejouer->getModeles()->getCocktailValeur() * $multiplicateur;

                $jouer->setPartieJoueur1Score($score);
                $em->flush();
            }
        } else {
            $em = $this->getDoctrine()->getManager();
            $cartejouer->setCarteSituation('plateauJ1');
            $jouer->setJ1cartejouer('1');
            if ($cartejouer->getModeles()->getCocktailExtra() == 1) {
                $score += -40;
            } else {
                $score += $cartejouer->getModeles()->getCocktailValeur();
                $score += -20;
            }
            $jouer->setPartieJoueur1Score($score);
            $em->flush();
        }



        } elseif ($jouer->getPartieTour() == $jouer->getJoueur2()){
            $cartesplateau = $this->getDoctrine()->getRepository('AppBundle:stuff_me_cartes')->findBy(['carteSituation' => 'plateauJ2', 'parties' => $partieid]);
            $score = $jouer->getPartieJoueur2Score();
            if (!empty($cartesplateau)) {
                $remplis = 0;
                $etejouer = 0;
                foreach ($cartesplateau as $val) {
                    if ($val->getModeles()->getCocktailCategorie() == $categorie) {
                        if ($val->getModeles()->getCocktailValeur() <= $valeur) {
                            $etejouer = 1;
                        }
                    } else {
                        $remplis++;
                    }
                }
                if ($remplis == count($cartesplateau) || $etejouer == 1) {
                    $em = $this->getDoctrine()->getManager();
                    $cartejouer->setCarteSituation('plateauJ2');
                    $jouer->setJ2cartejouer('1');

                    $multiplicateur = 1;
                    if ($cartejouer->getModeles()->getCocktailExtra() == 1) {
                        $multiplicateur++;
                    }
                    foreach ($cartesplateau as $val) {
                        if ($val->getModeles()->getCocktailCategorie() == $categorie && $val->getModeles()->getCocktailExtra() == 1) {
                            if ($cartejouer->getModeles()->getCocktailExtra() == 1) {
                                $score += -20;
                            }
                            $multiplicateur++;
                        }
                    }
                    if ($remplis == count($cartesplateau)) {
                        $score += -20 * $multiplicateur;
                    }
                    $score += $cartejouer->getModeles()->getCocktailValeur() * $multiplicateur;

                    $jouer->setPartieJoueur2Score($score);
                    $em->flush();
                }
            } else {
                $em = $this->getDoctrine()->getManager();
                $cartejouer->setCarteSituation('plateauJ2');
                $jouer->setJ2cartejouer('1');

                if ($cartejouer->getModeles()->getCocktailExtra() == 1) {
                    $score += -40;
                } else {
                    $score += $cartejouer->getModeles()->getCocktailValeur();
                    $score += -20;
                }
                $jouer->setPartieJoueur2Score($score);

                $em->flush();
            }
        }
        return $this->redirectToRoute('afficherpartie', ['id' => $partieid]);
    }


}