<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * stuff_me_partie
 *
 * @ORM\Table(name="stuff_me_partie")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\stuff_me_partieRepository")
 */
class stuff_me_partie
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="partie_joueur1_score", type="bigint", nullable=true)
     */
    private $partieJoueur1Score;

    /**
     * @var int
     *
     * @ORM\Column(name="partie_joueur2_score", type="bigint", nullable=true)
     */
    private $partieJoueur2Score;

    /**
     * @var bool
     *
     * @ORM\Column(name="j1_carte_jouer", type="boolean", nullable=true)
     */
    private $j1cartejouer;

    /**
     * @var bool
     *
     * @ORM\Column(name="j2_carte_jouer", type="boolean", nullable=true)
     */
    private $j2cartejouer;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\stuff_me_user", inversedBy="partie1", fetch="EAGER")
     */
    private $joueur1;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\stuff_me_user", inversedBy="partie2", fetch="EAGER")
     */
    private $joueur2;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\stuff_me_user", fetch="EAGER")
     */
    private $partieTour;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set partieJoueur1Score
     *
     * @param integer $partieJoueur1Score
     *
     * @return stuff_me_partie
     */
    public function setPartieJoueur1Score($partieJoueur1Score)
    {
        $this->partieJoueur1Score = $partieJoueur1Score;

        return $this;
    }

    /**
     * Get partieJoueur1Score
     *
     * @return int
     */
    public function getPartieJoueur1Score()
    {
        return $this->partieJoueur1Score;
    }

    /**
     * Set partieJoueur2Score
     *
     * @param integer $partieJoueur2Score
     *
     * @return stuff_me_partie
     */
    public function setPartieJoueur2Score($partieJoueur2Score)
    {
        $this->partieJoueur2Score = $partieJoueur2Score;

        return $this;
    }

    /**
     * Get partieJoueur2Score
     *
     * @return int
     */
    public function getPartieJoueur2Score()
    {
        return $this->partieJoueur2Score;
    }

    /**
     * Set joueur1
     *
     * @param \AppBundle\Entity\stuff_me_user $joueur1
     *
     * @return stuff_me_partie
     */
    public function setJoueur1(\AppBundle\Entity\stuff_me_user $joueur1 = null)
    {
        $this->joueur1 = $joueur1;

        return $this;
    }

    /**
     * Get joueur1
     *
     * @return \AppBundle\Entity\stuff_me_user
     */
    public function getJoueur1()
    {
        return $this->joueur1;
    }

    /**
     * Set joueur2
     *
     * @param \AppBundle\Entity\stuff_me_user $joueur2
     *
     * @return stuff_me_partie
     */
    public function setJoueur2(\AppBundle\Entity\stuff_me_user $joueur2 = null)
    {
        $this->joueur2 = $joueur2;

        return $this;
    }

    /**
     * Get joueur2
     *
     * @return \AppBundle\Entity\stuff_me_user
     */
    public function getJoueur2()
    {
        return $this->joueur2;
    }

    /**
     * Set partieTour
     *
     * @param \AppBundle\Entity\stuff_me_user $partieTour
     *
     * @return stuff_me_partie
     */
    public function setPartieTour(\AppBundle\Entity\stuff_me_user $partieTour = null)
    {
        $this->partieTour = $partieTour;

        return $this;
    }

    /**
     * Get partieTour
     *
     * @return \AppBundle\Entity\stuff_me_user
     */
    public function getPartieTour()
    {
        return $this->partieTour;
    }

    /**
     * Set j1cartejouer
     *
     * @param boolean $j1cartejouer
     *
     * @return stuff_me_partie
     */
    public function setJ1cartejouer($j1cartejouer)
    {
        $this->j1cartejouer = $j1cartejouer;

        return $this;
    }

    /**
     * Get j1cartejouer
     *
     * @return boolean
     */
    public function getJ1cartejouer()
    {
        return $this->j1cartejouer;
    }

    /**
     * Set j2cartejouer
     *
     * @param boolean $j2cartejouer
     *
     * @return stuff_me_partie
     */
    public function setJ2cartejouer($j2cartejouer)
    {
        $this->j2cartejouer = $j2cartejouer;

        return $this;
    }

    /**
     * Get j2cartejouer
     *
     * @return boolean
     */
    public function getJ2cartejouer()
    {
        return $this->j2cartejouer;
    }
}
