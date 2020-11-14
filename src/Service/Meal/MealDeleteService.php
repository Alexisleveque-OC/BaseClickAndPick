<?php


namespace App\Service\Meal;


use App\Entity\Meal;
use App\Repository\OrderLineRepository;
use Doctrine\ORM\EntityManagerInterface;

class MealDeleteService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;
    /**
     * @var OrderLineRepository
     */
    private OrderLineRepository $orderLineRepository;

    public function __construct(EntityManagerInterface $manager, OrderLineRepository $orderLineRepository)
    {
        $this->manager = $manager;
        $this->orderLineRepository = $orderLineRepository;
    }

    public function deleteMeal(Meal $meal)
    {
        $linesLinkToMeal = $this->orderLineRepository->findAllByMeal($meal);
        foreach ($linesLinkToMeal as $line){
            $line->setMeal(null);
            $this->manager->persist($line);
        }

        $this->manager->remove($meal);
        $this->manager->flush();
    }
}