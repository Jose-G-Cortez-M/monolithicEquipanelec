<?php

namespace App\Entity;

use App\Repository\MovementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MovementRepository::class)
 */
class Movement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $orderdate;

    /**
     * @ORM\Column(type="float")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Tool::class,inversedBy="movements")
     */
    private $tools;

    /**
     * @ORM\ManyToOne(targetEntity=Material::class, inversedBy="movements")
     */
    private $materials;

    /**
     * @ORM\ManyToOne(targetEntity=Cable::class, inversedBy="movements")
     */
    private $cables;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="movements")
     */
    private $projects;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderdate(): ?\DateTimeInterface
    {
        return $this->orderdate;
    }

    public function setOrderdate(\DateTimeInterface $orderdate): self
    {
        $this->orderdate = $orderdate;

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
}
