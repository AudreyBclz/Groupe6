<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
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
    private $nameProduct;

    /**
     * @ORM\Column(type="text")
     */
    private $descrProduct;

    /**
     * @ORM\Column(type="float")
     */
    private $priceProduct;

    /**
     * @ORM\Column(type="date")
     */
    private $dateCreaProduct;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateModifProduct;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $statusProduct;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photoProduct;

    /**
     * @ORM\Column(type="integer")
     */
    private $stockProduct;

    /**
     * @ORM\ManyToOne(targetEntity=Gender::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $gender;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity=Order::class, mappedBy="product")
     */
    private $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameProduct(): ?string
    {
        return $this->nameProduct;
    }

    public function setNameProduct(string $nameProduct): self
    {
        $this->nameProduct = $nameProduct;

        return $this;
    }

    public function getDescrProduct(): ?string
    {
        return $this->descrProduct;
    }

    public function setDescrProduct(string $descrProduct): self
    {
        $this->descrProduct = $descrProduct;

        return $this;
    }

    public function getPriceProduct(): ?float
    {
        return $this->priceProduct;
    }

    public function setPriceProduct(float $priceProduct): self
    {
        $this->priceProduct = $priceProduct;

        return $this;
    }

    public function getDateCreaProduct(): ?\DateTimeInterface
    {
        return $this->dateCreaProduct;
    }

    public function setDateCreaProduct(\DateTimeInterface $dateCreaProduct): self
    {
        $this->dateCreaProduct = $dateCreaProduct;

        return $this;
    }

    public function getDateModifProduct(): ?\DateTimeInterface
    {
        return $this->dateModifProduct;
    }

    public function setDateModifProduct(?\DateTimeInterface $dateModifProduct): self
    {
        $this->dateModifProduct = $dateModifProduct;

        return $this;
    }

    public function getStatusProduct(): ?bool
    {
        return $this->statusProduct;
    }

    public function setStatusProduct(?bool $statusProduct): self
    {
        $this->statusProduct = $statusProduct;

        return $this;
    }

    public function getPhotoProduct(): ?string
    {
        return $this->photoProduct;
    }

    public function setPhotoProduct(?string $photoProduct): self
    {
        $this->photoProduct = $photoProduct;

        return $this;
    }

    public function getStockProduct(): ?int
    {
        return $this->stockProduct;
    }

    public function setStockProduct(int $stockProduct): self
    {
        $this->stockProduct = $stockProduct;

        return $this;
    }

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(?Gender $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->addProduct($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            $order->removeProduct($this);
        }

        return $this;
    }
}
