<?php

namespace App\Controller;

use App\Service\Meal\ListCategoriesService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    /**
     * @Route("/menu/management", name="menu_management")
     * @IsGranted("MEAL_CREATE")
     */
    public function displayMenu(ListCategoriesService $listCategories): Response
    {
        $categories = $listCategories->listCategories();

        return $this->render('menu/index.html.twig', [
            'categories' => $categories,
        ]);
    }
}
