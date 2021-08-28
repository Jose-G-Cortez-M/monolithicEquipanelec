<?php

namespace App\Entity;

use App\Repository\ProjectCloseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ProjectCloseRepository::class)
 */
class ProjectClose
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(
     *      max = 100,
     *      maxMessage = "El numero de contrato no puede tener más de 100 carácteres"
     * )
     */
    private ?string $contract_number;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
    * @Assert\Length(
     *      max = 100,
     *      maxMessage = "El nombre del proyecto no puede tener más de 100 carácteres"
     * )
     */
    private ?string $name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $registration_date;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $totalCost;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $startDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $endTime;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private ?array $date = [];

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $commercialValue;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $total_cost_task;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $total_cost_inventory;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContractNumber(): ?string
    {
        return $this->contract_number;
    }

    public function setContractNumber(?string $contract_number): self
    {
        $this->contract_number = $contract_number;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registration_date;
    }

    public function setRegistrationDate(?\DateTimeInterface $registration_date): self
    {
        $this->registration_date = $registration_date;

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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(?\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getDate(): ?array
    {
        return $this->date;
    }

    public function setDate(?array $date): self
    {
        $this->date = $date;

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

    public function getTotalCostTask(): ?float
    {
        return $this->total_cost_task;
    }

    public function setTotalCostTask(?float $total_cost_task): self
    {
        $this->total_cost_task = $total_cost_task;

        return $this;
    }

    public function getTotalCostInventory(): ?float
    {
        return $this->total_cost_inventory;
    }

    public function setTotalCostInventory(?float $total_cost_inventory): self
    {
        $this->total_cost_inventory = $total_cost_inventory;

        return $this;
    }
}
