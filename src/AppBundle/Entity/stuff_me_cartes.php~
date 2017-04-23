<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * stuff_me_cartes
 *
 * @ORM\Table(name="stuff_me_cartes")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\stuff_me_cartesRepository")
 */
class stuff_me_cartes
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
     * @ORM\Column(name="joueur_id_", type="bigint", nullable=true)
     */
    private $joueurId;

    /**
     * @var int
     *
     * @ORM\Column(name="partie_id_", type="bigint", nullable=true)
     */
    private $partieId;

    /**
     * @var int
     *
     * @ORM\Column(name="cocktail_id_", type="bigint", nullable=true)
     */
    private $cocktailId;

    /**
     * @var string
     *
     * @ORM\Column(name="carte_situation", type="string", length=255)
     */
    private $carteSituation;

    /**
     * @var int
     *
     * @ORM\Column(name="carte_ordre", type="bigint", nullable=true)
     */
    private $carteOrdre;




    /**
     * Many stuff_me_cartes have One stuff_me_cocktail.
     * @ORM\ManyToOne(targetEntity="stuff_me_cocktail")
     */
    private $modeles;

    /**
     * Many stuff_me_cartes have One stuff_me_partie
     * @ORM\ManyToOne(targetEntity="stuff_me_partie")
     */
    private $parties;




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
     * Set joueurId
     *
     * @param integer $joueurId
     *
     * @return stuff_me_cartes
     */
    public function setJoueurId($joueurId)
    {
        $this->joueurId = $joueurId;

        return $this;
    }

    /**
     * Get joueurId
     *
     * @return int
     */
    public function getJoueurId()
    {
        return $this->joueurId;
    }

    /**
     * Set partieId
     *
     * @param integer $partieId
     *
     * @return stuff_me_cartes
     */
    public function setPartieId($partieId)
    {
        $this->partieId = $partieId;

        return $this;
    }

    /**
     * Get partieId
     *
     * @return int
     */
    public function getPartieId()
    {
        return $this->partieId;
    }

    /**
     * Set cocktailId
     *
     * @param integer $cocktailId
     *
     * @return stuff_me_cartes
     */
    public function setCocktailId($cocktailId)
    {
        $this->cocktailId = $cocktailId;

        return $this;
    }

    /**
     * Get cocktailId
     *
     * @return int
     */
    public function getCocktailId()
    {
        return $this->cocktailId;
    }

    /**
     * Set carteSituation
     *
     * @param boolean $carteSituation
     *
     * @return stuff_me_cartes
     */
    public function setCarteSituation($carteSituation)
    {
        $this->carteSituation = $carteSituation;

        return $this;
    }

    /**
     * Get carteSituation
     *
     * @return bool
     */
    public function getCarteSituation()
    {
        return $this->carteSituation;
    }

    /**
     * Set carteOrdre
     *
     * @param integer $carteOrdre
     *
     * @return stuff_me_cartes
     */
    public function setCarteOrdre($carteOrdre)
    {
        $this->carteOrdre = $carteOrdre;

        return $this;
    }

    /**
     * Get carteOrdre
     *
     * @return int
     */
    public function getCarteOrdre()
    {
        return $this->carteOrdre;
    }

    /**
     * Set modeles
     *
     * @param \AppBundle\Entity\stuff_me_cocktail $modeles
     *
     * @return stuff_me_cartes
     */
    public function setModeles(\AppBundle\Entity\stuff_me_cocktail $modeles = null)
    {
        $this->modeles = $modeles;

        return $this;
    }

    /**
     * Get modeles
     *
     * @return \AppBundle\Entity\stuff_me_cocktail
     */
    public function getModeles()
    {
        return $this->modeles;
    }

    /**
     * Set parties
     *
     * @param \AppBundle\Entity\stuff_me_partie $parties
     *
     * @return stuff_me_cartes
     */
    public function setParties(\AppBundle\Entity\stuff_me_partie $parties = null)
    {
        $this->parties = $parties;

        return $this;
    }

    /**
     * Get parties
     *
     * @return \AppBundle\Entity\stuff_me_partie
     */
    public function getParties()
    {
        return $this->parties;
    }
}
