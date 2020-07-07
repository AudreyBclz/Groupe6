<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
class Address
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $firstAddress;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $secondAddress;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $zipcodeAddress;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $townAddress;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $countryAddress;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="address")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstAddress(): ?string
    {
        return $this->firstAddress;
    }

    public function setFirstAddress(string $firstAddress): self
    {
        $this->firstAddress = htmlspecialchars(trim($firstAddress));

        return $this;
    }

    public function getSecondAddress(): ?string
    {
        return $this->secondAddress;
    }

    public function setSecondAddress(?string $secondAddress): self
    {
        $this->secondAddress = $secondAddress;

        return $this;
    }

    public function getZipcodeAddress(): ?string
    {
        return $this->zipcodeAddress;
    }

    public function setZipcodeAddress(string $zipcodeAddress): self
    {
        $this->zipcodeAddress = htmlspecialchars(trim($zipcodeAddress));

        return $this;
    }

    public function getTownAddress(): ?string
    {
        return $this->townAddress;
    }

    public function setTownAddress(string $townAddress): self
    {
        $this->townAddress = htmlspecialchars(trim($townAddress));

        return $this;
    }

    public function getCountryAddress(): ?string
    {
        return $this->countryAddress;
    }

    public function setCountryAddress(string $countryAddress): self
    {
        $this->countryAddress = htmlspecialchars(trim($countryAddress));

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
            $user->setAddress($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getAddress() === $this) {
                $user->setAddress(null);
            }
        }

        return $this;
    }
}
