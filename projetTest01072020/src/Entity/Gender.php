<?php

namespace App\Entity;

use App\Repository\GenderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GenderRepository::class)
 */
class Gender
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nameGender;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameGender(): ?string
    {
        return $this->nameGender;
    }

    public function setNameGender(string $nameGender): self
    {
        $this->nameGender = $nameGender;

        return $this;
    }
}
