<?php


namespace App\Controller;


use App\Entity\Meal;
use App\Form\MealType;
use App\Service\Meal\CreateMealService;
use App\Service\Meal\EditService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MealEditController extends AbstractController
{
    /**
     * @Route("/meals/edit/{id}", name="meal_edit")
     * @param Request $request
     * @param EditService $editServiceMeal
     * @param Meal $meal
     * @return Response
     * @IsGranted("MEAL_EDIT", subject="meal")
     */
    public function createMeal(Request $request,
                               EditService $editServiceMeal,
                               Meal $meal
    ): Response
    {
        $form = $this->createForm(MealType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $editServiceMeal->editMeal($meal, $form->getData());

            return $this->redirectToRoute('menu_management');
        }

        return $this->render('Meal/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}