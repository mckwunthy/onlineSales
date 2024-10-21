<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\Commandes;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
#[ORM\Table(name: "Paniers")]
class Panier
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'basket')]
    private $commander;

    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'panierDeProduit')]
    private $products;

    /*#[ORM\OneToOne(targetEntity: Commandes::class, inversedBy: 'panierCommande')]
    private $commandePanier;*/

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

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
     * Get the value of commander
     */
    public function getCommander()
    {
        return $this->commander;
    }

    /**
     * Set the value of commander
     *
     * @return  self
     */
    public function setCommander($commander)
    {
        $this->commander = $commander;

        return $this;
    }

    /**
     * Get the value of products
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set the value of products
     *
     * @return  self
     */
    public function setProducts($products)
    {
        $this->products = $products;

        return $this;
    }

    /*
    public function addProducts(Product $product)
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setPanierDeProduit($this);
        }
        return $this;
    }
    */
    public function addProducts(Product $product)
    {
        // if (!$this->products->contains($product)) {
        $this->products->add($product);
        $product->setPanierDeProduit($this);
        // }
        return $this;
    }

    public function removeProductst(Product $prodcut)
    {
        if ($this->products->removeElement($prodcut)) {
            if ($prodcut->getPanierDeProduit() === $this) {
                $prodcut->setPanierDeProduit(null);
            }
        }
        return $this;
    }
}
