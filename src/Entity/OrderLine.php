<?php

namespace App\Entity;

use App\Repository\OrderLineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderLineRepository::class)
 */
class OrderLine
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Order::class, inversedBy="orderLine", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_order;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class)
     */
    private $product_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    public function __construct()
    {
        $this->product_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdOrder(): ?order
    {
        return $this->id_order;
    }

    public function setIdOrder(order $id_order): self
    {
        $this->id_order = $id_order;

        return $this;
    }

    /**
     * @return Collection|product[]
     */
    public function getProductId(): Collection
    {
        return $this->product_id;
    }

    public function addProductId(product $productId): self
    {
        if (!$this->product_id->contains($productId)) {
            $this->product_id[] = $productId;
        }

        return $this;
    }

    public function removeProductId(product $productId): self
    {
        $this->product_id->removeElement($productId);

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
