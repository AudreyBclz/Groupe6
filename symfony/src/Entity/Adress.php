<?php

namespace App\Entity;

use App\Repository\AdressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdressRepository::class)
 */
class Adress
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $firstAdress;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $secondAdress;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $zipcodeAdress;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $townAdress;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $countryAdress;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="adress")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="adress")
     */


    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstAdress(): ?string
    {
        return $this->firstAdress;
    }

    public function setFirstAdress(string $firstAdress): self
    {
        $this->firstAdress = $firstAdress;

        return $this;
    }

    public function getSecondAdress(): ?string
    {
        return $this->secondAdress;
    }

    public function setSecondAdress(?string $secondAdress): self
    {
        $this->secondAdress = $secondAdress;

        return $this;
    }

    public function getZipcodeAdress(): ?string
    {
        return $this->zipcodeAdress;
    }

    public function setZipcodeAdress(string $zipcodeAdress): self
    {
        $this->zipcodeAdress = $zipcodeAdress;

        return $this;
    }

    public function getTownAdress(): ?string
    {
        return $this->townAdress;
    }

    public function setTownAdress(string $townAdress): self
    {
        $this->townAdress = $townAdress;

        return $this;
    }

    public function getCountryAdress(): ?string
    {
        return $this->countryAdress;
    }

    public function setCountryAdress(string $countryAdress): self
    {
        $this->countryAdress = $countryAdress;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setAdress($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getAdress() === $this) {
                $user->setAdress(null);
            }
        }

        return $this;
    }
}
