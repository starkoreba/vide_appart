<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoomRepository::class)
 */
class Room
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="id_room", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_user;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="id_room", orphanRemoval=true)
     */
    private $id_prod;

    public function __construct()
    {
        $this->id_prod = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?user
    {
        return $this->id_user;
    }

    public function setIdUser(user $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    /**
     * @return Collection|product[]
     */
    public function getIdProd(): Collection
    {
        return $this->id_prod;
    }

    public function addIdProd(product $idProd): self
    {
        if (!$this->id_prod->contains($idProd)) {
            $this->id_prod[] = $idProd;
            $idProd->setIdRoom($this);
        }

        return $this;
    }

    public function removeIdProd(product $idProd): self
    {
        if ($this->id_prod->removeElement($idProd)) {
            // set the owning side to null (unless already changed)
            if ($idProd->getIdRoom() === $this) {
                $idProd->setIdRoom(null);
            }
        }

        return $this;
    }
}
