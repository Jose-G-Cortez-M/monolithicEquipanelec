<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
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
     *      maxMessage = "El nombre de la compañia no puede tener más de 100 carácteres"
     * )
     */
    private ?string $company;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(
     *      max = 100,
     *      maxMessage = "El nombre del representante no puede tener más de 100 carácteres"
     * )
     */
    private string $representative;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\Length(
     *      max = 50,
     *      maxMessage = "El teléfono no puede tener más de 50 carácteres"
     * )
     */
    private ?string $phone;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     * @Assert\Length(
     *      max = 150,
     *      maxMessage = "La dirección no puede tener más de 150 carácteres"
     * )
     */
    private ?string $direction;

    /**
     * @ORM\OneToMany(targetEntity=Project::class, mappedBy="clients", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="id", referencedColumnName="projects", onDelete="CASCADE")
     */
    private $projects;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $debt;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getRepresentative(): ?string
    {
        return $this->representative;
    }

    public function setRepresentative(string $representative): self
    {
        $this->representative = $representative;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getDirection(): ?string
    {
        return $this->direction;
    }

    public function setDirection(?string $direction): self
    {
        $this->direction = $direction;

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
            $project->setClients($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getClients() === $this) {
                $project->setClients(null);
            }
        }

        return $this;
    }

    public function getDebt(): ?float
    {
        return $this->debt;
    }

    public function setDebt(?float $debt): self
    {
        $this->debt = $debt;

        return $this;
    }
}
