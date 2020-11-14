<?php

namespace App\Entity;

use App\Repository\OrderLineRepository;
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
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mealName;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $mealPrice;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="orderLines")
     * @ORM\JoinColumn(nullable=false, name="order_id")
     */
    private $orderId;

    /**
     * @ORM\ManyToOne(targetEntity=Meal::class, inversedBy="orderLines")
     */
    private $meal;
public function __construct($meal)
{
    $this->meal = $meal;
    $this->mealName = $this->getMeal()->getName();
    $this->mealPrice = $this->getMeal()->getPrice();
}

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMeal(): ?Meal
    {
        return $this->meal;
    }

    public function setMeal(?Meal $meal): self
    {
        $this->meal = $meal;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMealName()
    {
        return $this->mealName;
    }

    /**
     */
    public function setMealName(): void
    {
        $this->mealName = $this->getMeal()->getName();
    }

    /**
     * @return mixed
     */
    public function getMealPrice()
    {
        return $this->mealPrice;
    }

    /**
     */
    public function setMealPrice(): void
    {
        $this->mealPrice = $this->getMeal()->getPrice();
    }
    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param mixed $orderId
     */
    public function setOrderId($orderId): void
    {
        $this->orderId = $orderId;
    }


}
