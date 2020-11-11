<?php

namespace App\Controller;

use App\Entity\Meal;
use App\Form\MealType;
use App\Service\Meal\ListCategoriesService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    /**
     * @Route("/menu/management", name="menu_management")
     * @IsGranted("MENU_EDIT"))
     * @param ListCategoriesService $listCategories
     * @return Response
     */
    public function displayMenu(ListCategoriesService $listCategories): Response
    {
        $categories = $listCategories->listCategories();
        $formMeal = $this->createForm(MealType::class);

        return $this->render('menu/index.html.twig', [
            'categories' => $categories,
            'formMeal' => $formMeal->createView(),
        ]);
    }
}
