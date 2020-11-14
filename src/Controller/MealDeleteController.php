<?php

namespace App\Controller;

use App\Entity\Meal;
use App\Service\Meal\MealDeleteService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MealDeleteController extends AbstractController
{
    /**
     * @Route("/meals/delete/{id}", name="meal_delete")
     * @param MealDeleteService $mealDelete
     * @param Meal $meal
     * @return Response
     * @IsGranted("MEAL_DELETE", subject="meal")
     */
    public function mealDelete(MealDeleteService $mealDelete, Meal $meal): Response
    {
        $mealDelete->deleteMeal($meal);

        return $this->redirectToRoute('menu_management', [
        ]);
    }
}
