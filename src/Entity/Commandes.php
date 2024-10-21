<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Panier;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "Commandes")]
class Commandes
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $facture;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'userCommandes')]
    private $commander;

    #[ORM\OneToOne(targetEntity: Panier::class)]
    private $panierCommande;

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
     * Get the value of facture
     */
    public function getFacture()
    {
        return $this->facture;
    }

    /**
     * Set the value of facture
     *
     * @return  self
     */
    public function setFacture($facture)
    {
        $this->facture = $facture;

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
     * Get the value of panierCommande
     */
    public function getPanierCommande()
    {
        return $this->panierCommande;
    }

    /**
     * Set the value of panierCommande
     *
     * @return  self
     */
    public function setPanierCommande($panierCommande)
    {
        $this->panierCommande = $panierCommande;

        return $this;
    }
}
