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
     * @var string
     *
     * @ORM\Column(name="partie_joueur1", type="string", length=255)
     */
    private $partieJoueur1;

    /**
     * @var string
     *
     * @ORM\Column(name="partie_joueur2", type="string", length=255)
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
     * @param string $partieJoueur1
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
     * @return string
     */
    public function getPartieJoueur1()
    {
        return $this->partieJoueur1;
    }

    /**
     * Set partieJoueur2
     *
     * @param string $partieJoueur2
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
     * @return string
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

