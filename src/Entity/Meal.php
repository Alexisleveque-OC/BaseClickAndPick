<?php

namespace App\Entity;

use App\Repository\MealRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MealRepository::class)
 */
class Meal
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $price;


    /**
     * @ORM\OneToMany(targetEntity=SellTo::class, mappedBy="meal")
     */
    private $sellTo;

    /**
     * @ORM\OneToMany(targetEntity=OrderLine::class, mappedBy="meal")
     */
    private $orderLines;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="meals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;



    public function __construct()
    {
        $this->orderId = new ArrayCollection();
        $this->sellTo = new ArrayCollection();
        $this->orderLines = new ArrayCollection();
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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }


    /**
     * @return Collection|SellTo[]
     */
    public function getSellTo(): Collection
    {
        return $this->sellTo;
    }

    public function addSellTo(SellTo $sellTo): self
    {
        if (!$this->sellTo->contains($sellTo)) {
            $this->sellTo[] = $sellTo;
            $sellTo->setMeal($this);
        }

        return $this;
    }

    public function removeSellTo(SellTo $sellTo): self
    {
        if ($this->sellTo->removeElement($sellTo)) {
            // set the owning side to null (unless already changed)
            if ($sellTo->getMeal() === $this) {
                $sellTo->setMeal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|OrderLine[]
     */
    public function getOrderLines(): Collection
    {
        return $this->orderLines;
    }

    public function addOrderLine(OrderLine $orderLine): self
    {
        if (!$this->orderLines->contains($orderLine)) {
            $this->orderLines[] = $orderLine;
            $orderLine->setMeal($this);
        }

        return $this;
    }

    public function removeOrderLine(OrderLine $orderLine): self
    {
        if ($this->orderLines->removeElement($orderLine)) {
            // set the owning side to null (unless already changed)
            if ($orderLine->getMeal() === $this) {
                $orderLine->setMeal(null);
            }
        }

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

}
