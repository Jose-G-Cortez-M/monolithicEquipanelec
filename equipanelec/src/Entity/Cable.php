<?php

namespace App\Entity;

use App\Repository\CableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
     */
    private $availablemeter;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $weightpermeter;

    /**
     * @ORM\Column(type="float")
     */
    private $purchaseprice;

    /**
     * @ORM\Column(type="float")
     */
    private $saleprice;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Movement::class, mappedBy="cables", orphanRemoval=true)
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

    public function getAvailablemeter(): ?float
    {
        return $this->availablemeter;
    }

    public function setAvailablemeter(float $availablemeter): self
    {
        $this->availablemeter = $availablemeter;

        return $this;
    }

    public function getWeightpermeter(): ?float
    {
        return $this->weightpermeter;
    }

    public function setWeightpermeter(?float $weightpermeter): self
    {
        $this->weightpermeter = $weightpermeter;

        return $this;
    }

    public function getPurchaseprice(): ?float
    {
        return $this->purchaseprice;
    }

    public function setPurchaseprice(float $purchaseprice): self
    {
        $this->purchaseprice = $purchaseprice;

        return $this;
    }

    public function getSaleprice(): ?float
    {
        return $this->saleprice;
    }

    public function setSaleprice(float $saleprice): self
    {
        $this->saleprice = $saleprice;

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
