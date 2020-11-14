<?php

namespace App\Controller;

use App\Entity\Meal;
use App\Form\MealType;
use App\Service\Meal\CreateMealService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MealCreateController extends AbstractController
{
    /**
     * @Route("/meals/create", name="meal_create")
     * @param Request $request
     * @param CreateMealService $createMeal
     * @return Response
     * @IsGranted("MEAL_CREATE")
     */
    public function createMeal(Request $request,
                               CreateMealService $createMeal
                               ): Response
    {
        $form = $this->createForm(MealType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $meal = $form->getData();
            $createMeal->createMeal($meal);

            return $this->redirectToRoute('menu_management');
        }

        return $this->render('Meal/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
