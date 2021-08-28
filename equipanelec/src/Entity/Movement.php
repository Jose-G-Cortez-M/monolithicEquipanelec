<?php

namespace App\Entity;

use App\Repository\MovementRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovementRepository", repositoryClass=MovementRepository::class)
 */
class Movement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $orderDate;

    /**
     * @ORM\Column(type="float")
     * @Assert\PositiveOrZero
     */
    private float $quantity;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @ORM\ManyToOne(targetEntity=Tool::class,inversedBy="movements")
     * @ORM\JoinColumn(nullable=true)
     */
    private $tools;

    /**
     * @ORM\ManyToOne(targetEntity=Material::class, inversedBy="movements")
     * @ORM\JoinColumn(nullable=true)
     */
    private $materials;

    /**
     * @ORM\ManyToOne(targetEntity=Cable::class, inversedBy="movements", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $cables;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="movements", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $projects;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $totalCost;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $commercialValue;


    public function getOrderDate(): ?DateTimeInterface
    {
        return $this->orderDate;
    }

    public function setOrderDate(DateTimeInterface $orderDate): self
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getTools(): ?Tool
    {
        return $this->tools;
    }

    public function setTools(?Tool $tools): self
    {
        $this->tools = $tools;

        return $this;
    }

    public function getMaterials(): ?Material
    {
        return $this->materials;
    }

    public function setMaterials(?Material $materials): self
    {
        $this->materials = $materials;

        return $this;
    }

    public function getCables(): ?Cable
    {
        return $this->cables;
    }

    public function setCables(?Cable $cables): self
    {
        $this->cables = $cables;

        return $this;
    }

    public function getProjects(): ?Project
    {
        return $this->projects;
    }

    public function setProjects(?Project $projects): self
    {
        $this->projects = $projects;

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

    public function getTotalCost(): ?float
    {
        return $this->totalCost;
    }

    public function setTotalCost(?float $totalCost): self
    {
        $this->totalCost = $totalCost;

        return $this;
    }

    public function getCommercialValue(): ?float
    {
        return $this->commercialValue;
    }

    public function setCommercialValue(?float $commercialValue): self
    {
        $this->commercialValue = $commercialValue;

        return $this;
    }


}