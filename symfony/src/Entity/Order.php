<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\Column(type="string", length=150)
     */
    private $nameProductOrder;

    /**
     * @ORM\Column(type="float")
     */
    private $priceProductOrder;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantityOrder;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateOrder;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateDeliveryOrder;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $statusOrder;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, inversedBy="orders")
     */
    private $product;

    public function __construct()
    {
        $this->product = new ArrayCollection();
    }

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

    public function getQuantityOrder(): ?int
    {
        return $this->quantityOrder;
    }

    public function setQuantityOrder(int $quantityOrder): self
    {
        $this->quantityOrder = $quantityOrder;

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

    /**
     * @return Collection|Product[]
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->product->contains($product)) {
            $this->product[] = $product;
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->product->contains($product)) {
            $this->product->removeElement($product);
        }

        return $this;
    }
}
