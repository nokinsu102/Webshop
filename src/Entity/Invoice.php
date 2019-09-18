<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InvoiceRepository")
 */
class Invoice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $paid;

    /**
     * @ORM\Column(type="datetime")
     */
    private $paid_date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="user_id")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\InvoiceProduct", mappedBy="invoice")
     */
    private $invoice;

    /**
     * @ORM\Column(type="float")
     */
    private $Total;

    public function __construct()
    {
        $this->invoice = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPaid(): ?bool
    {
        return $this->paid;
    }

    public function setPaid(bool $paid): self
    {
        $this->paid = $paid;

        return $this;
    }

    public function getPaidDate(): ?\DateTimeInterface
    {
        return $this->paid_date;
    }

    public function setPaidDate(\DateTimeInterface $paid_date): self
    {
        $this->paid_date = $paid_date;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|InvoiceProduct[]
     */
    public function getInvoice(): Collection
    {
        return $this->invoice;
    }

    public function addInvoice(InvoiceProduct $invoice): self
    {
        if (!$this->invoice->contains($invoice)) {
            $this->invoice[] = $invoice;
            $invoice->setInvoice($this);
        }

        return $this;
    }

    public function removeInvoice(InvoiceProduct $invoice): self
    {
        if ($this->invoice->contains($invoice)) {
            $this->invoice->removeElement($invoice);
            // set the owning side to null (unless already changed)
            if ($invoice->getInvoice() === $this) {
                $invoice->setInvoice(null);
            }
        }

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->Total;
    }

    public function setTotal(float $Total): self
    {
        $this->Total = $Total;

        return $this;
    }
}
