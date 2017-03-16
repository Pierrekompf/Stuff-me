<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * stuff_me_cocktail
 *
 * @ORM\Table(name="stuff_me_cocktail")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\stuff_me_cocktailRepository")
 */
class stuff_me_cocktail
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
     * @ORM\Column(name="cocktail_nom", type="string", length=255)
     */
    private $cocktailNom;

    /**
     * @var string
     *
     * @ORM\Column(name="cocktail_categorie", type="string", length=255)
     */
    private $cocktailCategorie;

    /**
     * @var bool
     *
     * @ORM\Column(name="cocktail_extra", type="boolean")
     */
    private $cocktailExtra;

    /**
     * @var string
     *
     * @ORM\Column(name="cocktail_description", type="string", length=255)
     */
    private $cocktailDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="cocktail_image", type="string", length=255)
     */
    private $cocktailImage;


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
     * Set cocktailNom
     *
     * @param string $cocktailNom
     *
     * @return stuff_me_cocktail
     */
    public function setCocktailNom($cocktailNom)
    {
        $this->cocktailNom = $cocktailNom;

        return $this;
    }

    /**
     * Get cocktailNom
     *
     * @return string
     */
    public function getCocktailNom()
    {
        return $this->cocktailNom;
    }

    /**
     * Set cocktailCategorie
     *
     * @param string $cocktailCategorie
     *
     * @return stuff_me_cocktail
     */
    public function setCocktailCategorie($cocktailCategorie)
    {
        $this->cocktailCategorie = $cocktailCategorie;

        return $this;
    }

    /**
     * Get cocktailCategorie
     *
     * @return string
     */
    public function getCocktailCategorie()
    {
        return $this->cocktailCategorie;
    }

    /**
     * Set cocktailExtra
     *
     * @param boolean $cocktailExtra
     *
     * @return stuff_me_cocktail
     */
    public function setCocktailExtra($cocktailExtra)
    {
        $this->cocktailExtra = $cocktailExtra;

        return $this;
    }

    /**
     * Get cocktailExtra
     *
     * @return bool
     */
    public function getCocktailExtra()
    {
        return $this->cocktailExtra;
    }

    /**
     * Set cocktailDescription
     *
     * @param string $cocktailDescription
     *
     * @return stuff_me_cocktail
     */
    public function setCocktailDescription($cocktailDescription)
    {
        $this->cocktailDescription = $cocktailDescription;

        return $this;
    }

    /**
     * Get cocktailDescription
     *
     * @return string
     */
    public function getCocktailDescription()
    {
        return $this->cocktailDescription;
    }

    /**
     * Set cocktailImage
     *
     * @param string $cocktailImage
     *
     * @return stuff_me_cocktail
     */
    public function setCocktailImage($cocktailImage)
    {
        $this->cocktailImage = $cocktailImage;

        return $this;
    }

    /**
     * Get cocktailImage
     *
     * @return string
     */
    public function getCocktailImage()
    {
        return $this->cocktailImage;
    }
}

