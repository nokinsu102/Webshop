<?php
// src/Entity/User.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Invoice", mappedBy="user")
     */
    private $user_id;

    public function __construct()
    {
        parent::__construct();
        $this->user_id = new ArrayCollection();
        // your own logic
    }

    /**
     * @return Collection|Invoice[]
     */
    public function getUserId(): Collection
    {
        return $this->user_id;
    }

    public function addUserId(Invoice $userId): self
    {
        if (!$this->user_id->contains($userId)) {
            $this->user_id[] = $userId;
            $userId->setUser($this);
        }

        return $this;
    }

    public function removeUserId(Invoice $userId): self
    {
        if ($this->user_id->contains($userId)) {
            $this->user_id->removeElement($userId);
            // set the owning side to null (unless already changed)
            if ($userId->getUser() === $this) {
                $userId->setUser(null);
            }
        }

        return $this;
    }
}