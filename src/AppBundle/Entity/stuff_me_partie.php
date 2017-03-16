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
     * @ORM\Column(name="partie_joueur1", type="bigint")
     */
    private $partieJoueur1;

    /**
     * @var int
     *
     * @ORM\Column(name="partie_joueur2", type="bigint")
     */
    private $partieJoueur2;

    /**
     * @var int
     *
     * @ORM\Column(name="partie_joueur1_score", type="bigint")
     */
    private $partieJoueur1Score;

    /**
     * @var int
     *
     * @ORM\Column(name="partie_joueur2_score", type="bigint")
     */
    private $partieJoueur2Score;


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
     * Set partieJoueur1
     *
     * @param integer $partieJoueur1
     *
     * @return stuff_me_partie
     */
    public function setPartieJoueur1($partieJoueur1)
    {
        $this->partieJoueur1 = $partieJoueur1;

        return $this;
    }

    /**
     * Get partieJoueur1
     *
     * @return int
     */
    public function getPartieJoueur1()
    {
        return $this->partieJoueur1;
    }

    /**
     * Set partieJoueur2
     *
     * @param integer $partieJoueur2
     *
     * @return stuff_me_partie
     */
    public function setPartieJoueur2($partieJoueur2)
    {
        $this->partieJoueur2 = $partieJoueur2;

        return $this;
    }

    /**
     * Get partieJoueur2
     *
     * @return int
     */
    public function getPartieJoueur2()
    {
        return $this->partieJoueur2;
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
}

