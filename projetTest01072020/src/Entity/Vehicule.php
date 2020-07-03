<?php

namespace App\Entity;

use App\Repository\VehiculeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=VehiculeRepository::class)
 * @ORM\Entity
 * @ORM\Table(name="vehicule")
 * @Vich\Uploadable()
 */
class Vehicule
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
    private $nomVehicule;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $numImmat;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prixHt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbPorte;

    /**
     * @ORM\ManyToOne(targetEntity=Marque::class, inversedBy="vehicules")
     */
    private $marque;

    /**
     * @ORM\ManyToOne(targetEntity=Options::class, inversedBy="vehicules")
     */
    private $options;

    /**
     * @ORM\ManyToOne(targetEntity=TypeVehicule::class, inversedBy="vehicules")
     */
    private $typeVehicule;

    /**
     * @ORM\ManyToOne(targetEntity=Color::class, inversedBy="vehicules")
     */
    private $color;

    /**
     * @ORM\ManyToOne(targetEntity=Energy::class, inversedBy="vehicules")
     */
    private $energy;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @var File|null
     * @Assert\Image(mimeTypes={"image/jpeg", "image/jpg", "image/png"})
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="photo")
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
    }
    /**
     * @return Marque|null
     */
    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    /**
     * @param Marque|null $marque
     * @return $this
     */
    public function setMarque(?Marque $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNomVehicule()
    {
        return $this->nomVehicule;
    }

    /**
     * @param mixed $nomVehicule
     */
    public function setNomVehicule($nomVehicule): void
    {
        $this->nomVehicule = $nomVehicule;
    }

    /**
     * @return mixed
     */
    public function getNumImmat()
    {
        return $this->numImmat;
    }

    /**
     * @param mixed $numImmat
     */
    public function setNumImmat($numImmat): void
    {
        $this->numImmat = $numImmat;
    }

    /**
     * @return mixed
     */
    public function getPrixHt()
    {
        return $this->prixHt;
    }

    /**
     * @param mixed $prixHt
     */
    public function setPrixHt($prixHt): void
    {
        $this->prixHt = $prixHt;
    }

    /**
     * @return mixed
     */
    public function getNbPorte()
    {
        return $this->nbPorte;
    }

    /**
     * @param mixed $nbPorte
     */
    public function setNbPorte($nbPorte): void
    {
        $this->nbPorte = $nbPorte;
    }

    public function getOptions(): ?Options
    {
        return $this->options;
    }

    public function setOptions(?Options $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function getTypeVehicule(): ?TypeVehicule
    {
        return $this->typeVehicule;
    }

    public function setTypeVehicule(?TypeVehicule $typeVehicule): self
    {
        $this->typeVehicule = $typeVehicule;

        return $this;
    }

    public function getColor(): ?Color
    {
        return $this->color;
    }

    public function setColor(?Color $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getEnergy(): ?Energy
    {
        return $this->energy;
    }

    public function setEnergy(?Energy $energy): self
    {
        $this->energy = $energy;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }


}
