<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
#[ORM\Table(name: "Products")]
class Product
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private $id;

    #[ORM\Column(type: 'string', length: 120)]
    private $p_name;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'integer')]
    private $price;

    #[ORM\Column(type: 'string')]
    private $productUrl;

    #[ORM\ManyToOne(targetEntity: Panier::class, inversedBy: 'products')]
    private $panierDeProduit;

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of p_name
     */
    public function getP_name()
    {
        return $this->p_name;
    }

    /**
     * Set the value of p_name
     *
     * @return  self
     */
    public function setP_name($p_name)
    {
        $this->p_name = $p_name;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of panierDeProduit
     */
    public function getPanierDeProduit()
    {
        return $this->panierDeProduit;
    }

    /**
     * Set the value of panierDeProduit
     *
     * @return  self
     */
    public function setPanierDeProduit($panierDeProduit)
    {
        $this->panierDeProduit = $panierDeProduit;

        return $this;
    }

    /**
     * Get the value of productUrl
     */
    public function getProductUrl()
    {
        return $this->productUrl;
    }

    /**
     * Set the value of productUrl
     *
     * @return  self
     */
    public function setProductUrl($productUrl)
    {
        $this->productUrl = $productUrl;

        return $this;
    }
}