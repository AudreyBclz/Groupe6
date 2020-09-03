<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Exception;
/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @Vich\Uploadable()
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
     * @ORM\Column(type="integer")
     */
    private $stockProduct;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photoProduct;

    /**
     * @var File|null
     * @Assert\Image(mimeTypes={"image/jpeg", "image/jpg", "image/png"})
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="photoProduct")
     *
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     * @var null|DateTime
     */
    private $updated_at;

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File|null $imageFile
     *
     * @throws Exception
     */
    public function setImageFile( ?File $imageFile ): void {
        $this->imageFile = $imageFile;
        if($this->imageFile instanceof UploadedFile){
            $this->updated_at = new \DateTime('now');
        }
        //return $this;
    }
    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=Gender::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $gender;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="product")
     */
    private $orders;

    public function __construct()
    {
        $this->dateCreaProduct= new DateTime('now');
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
        $this->nameProduct = htmlspecialchars(trim($nameProduct));

        return $this;
    }

    public function getDescrProduct(): ?string
    {
        return $this->descrProduct;
    }

    public function setDescrProduct(string $descrProduct): self
    {
        $this->descrProduct = htmlspecialchars(trim($descrProduct));

        return $this;
    }

    public function getPriceProduct(): ?float
    {
        return $this->priceProduct;
    }

    public function setPriceProduct(float $priceProduct): self
    {
        $this->priceProduct = htmlspecialchars(trim($priceProduct));

        return $this;
    }

    public function getDateCreaProduct(): ?\DateTimeInterface
    {
        return $this->dateCreaProduct;
    }

    public function setDateCreaProduct(\DateTimeInterface $dateCreaProduct): self
    {
        $this->dateCreaProduct = htmlspecialchars(trim($dateCreaProduct));

        return $this;
    }

    public function getDateModifProduct(): ?\DateTimeInterface
    {
        return $this->dateModifProduct;
    }

    public function setDateModifProduct(?\DateTimeInterface $dateModifProduct): self
    {
        $this->dateModifProduct = htmlspecialchars(trim($dateModifProduct));

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
        $this->photoProduct = htmlspecialchars(trim($photoProduct));

        return $this;
    }

    public function getStockProduct(): ?int
    {
        return $this->stockProduct;
    }

    public function setStockProduct(int $stockProduct): self
    {
        $this->stockProduct = htmlspecialchars(trim($stockProduct));

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

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(?Gender $gender): self
    {
        $this->gender = $gender;

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
            $order->setProduct($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getProduct() === $this) {
                $order->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * toString
     * @return string
     */
    public function __toString()
    {
        return $this->getNameProduct();
    }
}
