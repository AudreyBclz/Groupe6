<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nameProductOrder;

    /**
     * @ORM\Column(type="float")
     */
    private $priceProductOrder;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantityProductOrder;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateOrder;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateDeliveryOrder;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $statusOrder;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameProductOrder(): ?string
    {
        return $this->nameProductOrder;
    }

    public function setNameProductOrder(string $nameProductOrder): self
    {
        $this->nameProductOrder = $nameProductOrder;

        return $this;
    }

    public function getPriceProductOrder(): ?float
    {
        return $this->priceProductOrder;
    }

    public function setPriceProductOrder(float $priceProductOrder): self
    {
        $this->priceProductOrder = $priceProductOrder;

        return $this;
    }

    public function getQuantityProductOrder(): ?int
    {
        return $this->quantityProductOrder;
    }

    public function setQuantityProductOrder(int $quantityProductOrder): self
    {
        $this->quantityProductOrder = $quantityProductOrder;

        return $this;
    }

    public function getDateOrder(): ?\DateTimeInterface
    {
        return $this->dateOrder;
    }

    public function setDateOrder(\DateTimeInterface $dateOrder): self
    {
        $this->dateOrder = $dateOrder;

        return $this;
    }

    public function getDateDeliveryOrder(): ?\DateTimeInterface
    {
        return $this->dateDeliveryOrder;
    }

    public function setDateDeliveryOrder(?\DateTimeInterface $dateDeliveryOrder): self
    {
        $this->dateDeliveryOrder = $dateDeliveryOrder;

        return $this;
    }

    public function getStatusOrder(): ?string
    {
        return $this->statusOrder;
    }

    public function setStatusOrder(?string $statusOrder): self
    {
        $this->statusOrder = $statusOrder;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
