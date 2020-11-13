<?php


namespace App\Service\Meal;


use App\Entity\Meal;
use Doctrine\ORM\EntityManagerInterface;

class MealDeleteService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function deleteMeal(Meal $meal)
    {
        $this->manager->remove($meal);
        $this->manager->flush();
    }
}