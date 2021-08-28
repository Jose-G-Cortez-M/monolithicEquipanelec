<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
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
     *      maxMessage = "El número de contrato no puede tener más de 100 carácteres"
     * )
     */
    private ?string $contractNumber;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(
     *      max = 100,
     *      maxMessage = "El nombre del proyecto no puede tener más de 100 carácteres"
     * )
     */
    private string $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $registrationDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $startDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $endTime;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\PositiveOrZero
     */
    private ?float $advances;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\PositiveOrZero
     */
    private ?float $totalCost;

    /**
     * @ORM\OneToMany(targetEntity=Movement::class, mappedBy="projects", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="id", referencedColumnName="movements", onDelete="CASCADE")
     */
    private $movements;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="projects", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $clients;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="projects")
     */
    private $users;


    /**
     * @ORM\ManyToMany(targetEntity=Task::class, inversedBy="projects")
     */
    private $tasks;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $commercialValue;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $totalCostTask;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $totalCostInventory;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $process;



    public function __construct()
    {
        $this->movements = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContractNumber(): ?string
    {
        return $this->contractNumber;
    }

    public function setContractNumber(?string $contractNumber): self
    {
        $this->contractNumber = $contractNumber;

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

    public function getRegistrationDate(): ?DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(DateTimeInterface $registrationDate): self
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    public function getStartDate(): ?DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndTime(): ?DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(?DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

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

    public function getAdvances(): ?float
    {
        return $this->advances;
    }

    public function setAdvances(?float $advances): self
    {
        $this->advances = $advances;

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
            $movement->setProjects($this);
        }

        return $this;
    }

    public function removeMovement(Movement $movement): self
    {
        if ($this->movements->removeElement($movement)) {
            // set the owning side to null (unless already changed)
            if ($movement->getProjects() === $this) {
                $movement->setProjects(null);
            }
        }

        return $this;
    }

    public function getClients(): ?Client
    {
        return $this->clients;
    }

    public function setClients(?Client $clients): self
    {
        $this->clients = $clients;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        $this->tasks->removeElement($task);

        return $this;
    }

    public function __toString():string
    {
        return $this->name;
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
        return $this->totalCostTask;
    }

    public function setTotalCostTask(?float $totalCostTask): self
    {
        $this->totalCostTask = $totalCostTask;

        return $this;
    }

    public function getTotalCostInventory(): ?float
    {
        return $this->totalCostInventory;
    }

    public function setTotalCostInventory(?float $totalCostInventory): self
    {
        $this->totalCostInventory = $totalCostInventory;

        return $this;
    }

    public function getProcess(): ?string
    {
        return $this->process;
    }

    public function setProcess(?string $process): self
    {
        $this->process = $process;

        return $this;
    }
}
