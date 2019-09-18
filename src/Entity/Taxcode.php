<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaxcodeRepository")
 */
class Taxcode
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
    private $country;

    /**
     * @ORM\Column(type="float")
     */
    private $value;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="taxcode")
     */
    private $taxcode_id;

    public function __construct()
    {
        $this->taxcode_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getTaxcodeId(): Collection
    {
        return $this->taxcode_id;
    }

    public function addTaxcodeId(Product $taxcodeId): self
    {
        if (!$this->taxcode_id->contains($taxcodeId)) {
            $this->taxcode_id[] = $taxcodeId;
            $taxcodeId->setTaxcode($this);
        }

        return $this;
    }

    public function removeTaxcodeId(Product $taxcodeId): self
    {
        if ($this->taxcode_id->contains($taxcodeId)) {
            $this->taxcode_id->removeElement($taxcodeId);
            // set the owning side to null (unless already changed)
            if ($taxcodeId->getTaxcode() === $this) {
                $taxcodeId->setTaxcode(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getCountry() . " - " . $this->getValue() . "%";
    }
}
