<?php

namespace App\Controller;

use App\Service\Restaurant\RestaurantList;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param RestaurantList $restaurantList
     * @return Response
     */
    public function index(RestaurantList $restaurantList): Response
    {
        $restaurants = $restaurantList->list();

        return $this->render('home/index.html.twig', [
            'restaurants' => $restaurants
        ]);
    }
}
