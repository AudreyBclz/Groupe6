<?php

namespace App\Entity;

use App\Repository\LivAddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LivAddressRepository::class)
 */
class LivAddress
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
    private $firstNameLiv;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $lastNameLiv;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $firstAdLiv;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $secondAdLiv;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $zipcodeLiv;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $townLiv;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $countryLiv;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="livAddress")
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

    public function getFirstNameLiv(): ?string
    {
        return $this->firstNameLiv;
    }

    public function setFirstNameLiv(string $firstNameLiv): self
    {
        $this->firstNameLiv = $firstNameLiv;

        return $this;
    }

    public function getLastNameLiv(): ?string
    {
        return $this->lastNameLiv;
    }

    public function setLastNameLiv(string $lastNameLiv): self
    {
        $this->lastNameLiv = $lastNameLiv;

        return $this;
    }

    public function getFirstAdLiv(): ?string
    {
        return $this->firstAdLiv;
    }

    public function setFirstAdLiv(string $firstAdLiv): self
    {
        $this->firstAdLiv = $firstAdLiv;

        return $this;
    }

    public function getSecondAdLiv(): ?string
    {
        return $this->secondAdLiv;
    }

    public function setSecondAdLiv(?string $secondAdLiv): self
    {
        $this->secondAdLiv = $secondAdLiv;

        return $this;
    }

    public function getZipcodeLiv(): ?string
    {
        return $this->zipcodeLiv;
    }

    public function setZipcodeLiv(string $zipcodeLiv): self
    {
        $this->zipcodeLiv = $zipcodeLiv;

        return $this;
    }

    public function getTownLiv(): ?string
    {
        return $this->townLiv;
    }

    public function setTownLiv(string $townLiv): self
    {
        $this->townLiv = $townLiv;

        return $this;
    }

    public function getCountryLiv(): ?string
    {
        return $this->countryLiv;
    }

    public function setCountryLiv(string $countryLiv): self
    {
        $this->countryLiv = $countryLiv;

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
            $user->setLivAddress($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getLivAddress() === $this) {
                $user->setLivAddress(null);
            }
        }

        return $this;
    }
}
