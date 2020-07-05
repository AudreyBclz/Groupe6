<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use DateTime;
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photoProduct;

    /**
     * @ORM\Column(type="integer")
     */
    private $stockProduct;

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

    public function __construct()
    {
        $this->dateCreaProduct= new DateTime('now');
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
}
