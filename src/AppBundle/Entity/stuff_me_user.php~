<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * stuff_me_user
 *
 * @ORM\Table(name="stuff_me_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\stuff_me_userRepository")
 */
class stuff_me_user extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
    * @var string
    *
    * @ORM\Column(name="nationalite", type="string", length=255, nullable=true)
    * @Assert\Length(
    *     min=2,
    *     max=25,
    *     minMessage="The nationnalite is too short.",
    *     maxMessage="The nationalite is too long.",
    *     groups={"Registration", "Profile"}
    * )
    */
    protected $nationalite;

    /**
     * @var int
     *
     * @ORM\Column(name="win", type="bigint", nullable=true)
     */
    private $win;

    /**
     * @var int
     *
     * @ORM\Column(name="loose", type="bigint", nullable=true)
     */
    private $loose;

    /**
     * @var int
     *
     * @ORM\Column(name="totale_score", type="bigint", nullable=true)
     */
    private $totale_score;





    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\stuff_me_partie", mappedBy="joueur1")
     */
    private $partie1;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\stuff_me_partie", mappedBy="joueur2")
     */
    private $partie2;

    private $parties;

    public function __construct()
    {
        parent::__construct();
        $this->partie1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->partie2 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->parties = new \Doctrine\Common\Collections\ArrayCollection();
    }


    public function getParties()
    {
        if (!is_null($this->partie1) || !is_null($this->partie2)){
            if (!is_null($this->partie1)){
                $this->parties[] = $this->partie1;
            }
            if (!is_null($this->partie2)){
                $this->parties[] = $this->partie2;
            }
            return $this->parties;
        }
    }

    /**
     * Add party
     *
     * @param \AppBundle\Entity\stuff_me_partie $party
     *
     * @return stuff_me_user
     */
    public function addParty(\AppBundle\Entity\stuff_me_partie $party)
    {
        $this->parties[] = $party;
        return $this;
    }
    /**
     * Remove party
     *
     * @param \AppBundle\Entity\stuff_me_partie $party
     */
    public function removeParty(\AppBundle\Entity\stuff_me_partie $party)
    {
        $this->parties->removeElement($party);
    }



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
     * Set nationalite
     *
     * @param string $nationalite
     *
     * @return stuff_me_user
     */
    public function setNationalite($nationalite)
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    /**
     * Get nationalite
     *
     * @return string
     */
    public function getNationalite()
    {
        return $this->nationalite;
    }

    /**
     * Set win
     *
     * @param integer $win
     *
     * @return stuff_me_user
     */
    public function setWin($win)
    {
        $this->win = $win;

        return $this;
    }

    /**
     * Get win
     *
     * @return integer
     */
    public function getWin()
    {
        return $this->win;
    }

    /**
     * Set loose
     *
     * @param integer $loose
     *
     * @return stuff_me_user
     */
    public function setLoose($loose)
    {
        $this->loose = $loose;

        return $this;
    }

    /**
     * Get loose
     *
     * @return integer
     */
    public function getLoose()
    {
        return $this->loose;
    }

    /**
     * Set totaleScore
     *
     * @param integer $totaleScore
     *
     * @return stuff_me_user
     */
    public function setTotaleScore($totaleScore)
    {
        $this->totale_score = $totaleScore;

        return $this;
    }

    /**
     * Get totaleScore
     *
     * @return integer
     */
    public function getTotaleScore()
    {
        return $this->totale_score;
    }

    /**
     * Add partie1
     *
     * @param \AppBundle\Entity\stuff_me_partie $partie1
     *
     * @return stuff_me_user
     */
    public function addPartie1(\AppBundle\Entity\stuff_me_partie $partie1)
    {
        $this->partie1[] = $partie1;

        return $this;
    }

    /**
     * Remove partie1
     *
     * @param \AppBundle\Entity\stuff_me_partie $partie1
     */
    public function removePartie1(\AppBundle\Entity\stuff_me_partie $partie1)
    {
        $this->partie1->removeElement($partie1);
    }

    /**
     * Get partie1
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPartie1()
    {
        return $this->partie1;
    }

    /**
     * Add partie2
     *
     * @param \AppBundle\Entity\stuff_me_partie $partie2
     *
     * @return stuff_me_user
     */
    public function addPartie2(\AppBundle\Entity\stuff_me_partie $partie2)
    {
        $this->partie2[] = $partie2;

        return $this;
    }

    /**
     * Remove partie2
     *
     * @param \AppBundle\Entity\stuff_me_partie $partie2
     */
    public function removePartie2(\AppBundle\Entity\stuff_me_partie $partie2)
    {
        $this->partie2->removeElement($partie2);
    }

    /**
     * Get partie2
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPartie2()
    {
        return $this->partie2;
    }

    /**
     * Add tour
     *
     * @param \AppBundle\Entity\stuff_me_partie $tour
     *
     * @return stuff_me_user
     */
    public function addTour(\AppBundle\Entity\stuff_me_partie $tour)
    {
        $this->tour[] = $tour;

        return $this;
    }

    /**
     * Remove tour
     *
     * @param \AppBundle\Entity\stuff_me_partie $tour
     */
    public function removeTour(\AppBundle\Entity\stuff_me_partie $tour)
    {
        $this->tour->removeElement($tour);
    }

    /**
     * Get tour
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTour()
    {
        return $this->tour;
    }


}
