<?php

namespace App\Entity;

use App\Repository\CableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CableRepository::class)
 */
class Cable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $barcode;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * @Assert\Positive
     */
    private $availability;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Positive
     */
    private $weightPerMeter;

    /**
     * @ORM\Column(type="float")
     * @Assert\Positive
     */
    private $purchasePrice;

    /**
     * @ORM\Column(type="float")
     * @Assert\PositiveOrZero()
     */
    private $salePrice;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Movement::class, mappedBy="cables", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="id", referencedColumnName="cables", onDelete="CASCADE")
     */
    private $movements;

    public function __construct()
    {
        $this->movements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    public function setBarcode(?string $barcode): self
    {
        $this->barcode = $barcode;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAvailability(): ?float
    {
        return $this->availability;
    }

    public function setAvailability(float $availability): self
    {
        $this->availability = $availability;

        return $this;
    }

    public function getWeightPerMeter(): ?float
    {
        return $this->weightPerMeter;
    }

    public function setWeightPerMeter(?float $weightPerMeter): self
    {
        $this->weightPerMeter = $weightPerMeter;

        return $this;
    }

    public function getPurchasePrice(): ?float
    {
        return $this->purchasePrice;
    }

    public function setPurchasePrice(float $purchasePrice): self
    {
        $this->purchasePrice = $purchasePrice;

        return $this;
    }

    public function getSalePrice(): ?float
    {
        return $this->salePrice;
    }

    public function setSalePrice(float $salePrice): self
    {
        $this->salePrice = $salePrice;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Movement[]
     */
    public function getMovements(): Collection
    {
        return $this->movements;
    }

    public function addMovement(Movement $movement): self
    {
        if (!$this->movements->contains($movement)) {
            $this->movements[] = $movement;
            $movement->setCables($this);
        }

        return $this;
    }

    public function removeMovement(Movement $movement): self
    {
        if ($this->movements->removeElement($movement)) {
            // set the owning side to null (unless already changed)
            if ($movement->getCables() === $this) {
                $movement->setCables(null);
            }
        }

        return $this;
    }

}
