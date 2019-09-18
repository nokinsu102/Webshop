<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="category_id")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Taxcode", inversedBy="taxcode_id")
     * @ORM\JoinColumn(nullable=false)
     */
    private $taxcode;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\InvoiceProduct", mappedBy="product")
     */
    private $product;

    public function __construct()
    {
        $this->product = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getTaxcode(): ?Taxcode
    {
        return $this->taxcode;
    }

    public function setTaxcode(?Taxcode $taxcode): self
    {
        $this->taxcode = $taxcode;

        return $this;
    }

    /**
     * @return Collection|InvoiceProduct[]
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(InvoiceProduct $product): self
    {
        if (!$this->product->contains($product)) {
            $this->product[] = $product;
            $product->setProduct($this);
        }

        return $this;
    }

    public function removeProduct(InvoiceProduct $product): self
    {
        if ($this->product->contains($product)) {
            $this->product->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getProduct() === $this) {
                $product->setProduct(null);
            }
        }

        return $this;
    }
}
