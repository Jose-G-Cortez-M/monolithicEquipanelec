<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(
     *      max = 100,
     *      maxMessage = "El nombre de la tarea no puede tener más de 100 carácteres"
     * )
     */
    private string $name;

    /**
     * @ORM\Column(type="float")
     * @Assert\Positive
     */
    private float $timePerMinute;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="float")
     * @Assert\Positive
     */
    private float $costPerTask;

    /**
     * @ORM\ManyToMany(targetEntity=Project::class, mappedBy="tasks")
     */
    private $projects;


    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTimePerMinute(): ?float
    {
        return $this->timePerMinute;
    }

    public function setTimePerMinute(float $timePerMinute): self
    {
        $this->timePerMinute = $timePerMinute;

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

    public function getCostPerTask(): ?float
    {
        return $this->costPerTask;
    }

    public function setCostPerTask(float $costPerTask): self
    {
        $this->costPerTask = $costPerTask;

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->addTask($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->removeElement($project)) {
            $project->removeTask($this);
        }

        return $this;
    }


}
