<?php

namespace App\Controller;

use App\Service\Meal\ListCategoriesService;
use App\Service\Restaurant\RestaurantList;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param RestaurantList $restaurantList
     * @param ListCategoriesService $listMeals
     * @return Response
     */
    public function index(RestaurantList $restaurantList, ListCategoriesService $listMeals): Response
    {
        $restaurants = $restaurantList->list();
        $categories = $listMeals->listCategories();

        return $this->render('home/index.html.twig', [
            'restaurants' => $restaurants,
            'categories' => $categories
        ]);
    }
}
