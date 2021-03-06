<?php

namespace App\Entity;

use App\Repository\MaterialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;



/**
 * @ORM\Entity(repositoryClass=MaterialRepository::class)
 * @Vich\Uploadable
 */
class Material
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     * @Assert\Length(
     *      max = 50,
     *      maxMessage = "El código de barras no puede tener más de 50 caracteres"
     * )
     */
    private ?string $barcode;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(
     *      max = 25,
     *      maxMessage = "El nombre del material no puede tener más de 25 caracteres"
     * )
     */
    private string $name;

    /**
     * @ORM\Column(type="float")
     * @Assert\PositiveOrZero
     * @Assert\Range(
     *      max = 99999,
     *      maxMessage = "No puedes registrar mas de 99999 unidades de este material "
     * )
     */
    private float $stock;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $location;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\Length(
     *      max = 50,
     *      maxMessage = "La marca del material no puede tener más de 50 caracteres"
     * )
     */
    private ?string $brand;

    /**
     * @ORM\Column(type="float")
     * @Assert\Positive
     * @Assert\Range(
     *      max = 99999,
     *      maxMessage = "El costo del material no puede sobrepasar los $ 99999"
     * )
     */
    private float $purchasePrice;

    /**
     * @ORM\Column(type="float")
     * @Assert\Positive
     * @Assert\Range(
     *      max = 99999,
     *      maxMessage = "El costo del material no puede sobrepasar los $ 99999"
     * )
     */
    private float $salePrice;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Positive
     * @Assert\Range(
     *      max = 99999,
     *      maxMessage = "No puedes registrar mas de 99999 unidades de este material "
     * )
     */
    private ?float $minimumLimit;

    /**
     * @Assert\File(
     *      mimeTypes={"image/png","image/jpeg","image/pjpeg"},
     *      mimeTypesMessage= "El tipo de archivo subido es inválido"
     * )
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="image.name", size="image.size", mimeType="image.mimeType", originalName="image.originalName", dimensions="image.dimensions")
     *
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Embedded(class="Vich\UploaderBundle\Entity\File")
     *
     * @var EmbeddedFile
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTimeInterface
     */
    private $updatedAt;


    /**
     * @ORM\OneToMany(targetEntity=Movement::class, mappedBy="materials", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="id", referencedColumnName="materials", onDelete="CASCADE")
     */
    private $movements;


    public function __construct()
    {
        $this->image = new EmbeddedFile();
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

    public function getStock(): ?float
    {
        return $this->stock;
    }

    public function setStock(float $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

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

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): self
    {
        $this->brand = $brand;

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

    public function getMinimumLimit(): ?float
    {
        return $this->minimumLimit;
    }

    public function setMinimumLimit(?float $minimumLimit): self
    {
        $this->minimumLimit = $minimumLimit;

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
            $movement->setMaterials($this);
        }

        return $this;
    }

    public function removeMovement(Movement $movement): self
    {
        if ($this->movements->removeElement($movement)) {
            // set the owning side to null (unless already changed)
            if ($movement->getMaterials() === $this) {
                $movement->setMaterials(null);
            }
        }

        return $this;
    }

    /**
     * @param File|UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null)
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImage(EmbeddedFile $image): void
    {
        $this->image = $image;
    }

    public function getImage(): ?EmbeddedFile
    {
        return $this->image;
    }


}
