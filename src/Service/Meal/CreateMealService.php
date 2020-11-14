<?php


namespace App\Service\Meal;


use App\Entity\Meal;
use Doctrine\ORM\EntityManagerInterface;

class CreateMealService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function createMeal(Meal $meal)
    {
        $this->manager->persist($meal);
        $this->manager->flush();

        return $meal;
    }
}