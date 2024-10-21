<?php

namespace App\Entity;

use App\Entity\Panier;
use App\Entity\Product;
use App\Entity\Commandes;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
#[ORM\Table(name: "Users")]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private $id;

    #[ORM\Column(type: 'string')]
    private $email;

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 120)]
    private $fullname;

    #[ORM\OneToMany(targetEntity: Panier::class, mappedBy: 'commander')]
    private $basket;

    #[ORM\OneToMany(targetEntity: Commandes::class, mappedBy: 'commander')]
    private $userCommandes;

    public function __construct()
    {
        $this->basket = new ArrayCollection();
        $this->userCommandes = new ArrayCollection();
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
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of fullname
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * Set the value of fullname
     *
     * @return  self
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Get the value of basket
     */
    public function getBasket()
    {
        return $this->basket;
    }

    /**
     * Set the value of basket
     *
     * @return  self
     */
    public function setBasket($basket)
    {
        $this->basket = $basket;

        return $this;
    }

    public function addBasket(Panier $panier)
    {
        if (!$this->basket->contains($panier)) {
            $this->basket->add($panier);
            $panier->setCommander($this);
        }
        return $this;
    }

    public function removeBasket(Panier $panier)
    {
        if ($this->basket->removeElement($panier)) {
            if ($panier->getCommander() === $this) {
                $panier->setCommander(null);
            }
        }
        return $this;
    }

    /**
     * Get the value of userCommandes
     */
    public function getUserCommandes()
    {
        return $this->userCommandes;
    }

    /**
     * Set the value of userCommandes
     *
     * @return  self
     */
    public function setUserCommandes($userCommandes)
    {
        $this->userCommandes = $userCommandes;

        return $this;
    }

    public function addUserCommandes(Commandes $commandes)
    {
        if (!$this->userCommandes->contains($commandes)) {
            $this->userCommandes->add($commandes);
            $commandes->setCommander($this);
        }
        return $this;
    }

    public function removeuserCommandes(Commandes $commandes)
    {
        if ($this->userCommandes->removeElement($commandes)) {
            if ($commandes->getCommander() === $this) {
                $commandes->setCommander(null);
            }
        }
        return $this;
    }
}
