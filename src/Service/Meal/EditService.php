<?php


namespace App\Service\Meal;


use App\Entity\Meal;
use Doctrine\ORM\EntityManagerInterface;

class EditService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function editMeal(Meal $meal, Meal $mealEdited)
    {
        $meal->setName($mealEdited->getName())
            ->setPrice($mealEdited->getPrice())
            ->setSellTo($mealEdited->getSellTo())
            ->setCategory($mealEdited->getCategory());

        $this->manager->persist($meal);
        $this->manager->flush();
    }
}