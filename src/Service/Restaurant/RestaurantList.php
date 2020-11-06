<?php


namespace App\Service\Restaurant;


use App\Repository\RestaurantRepository;

class RestaurantList
{
    /**
     * @var RestaurantRepository
     */
    private $repository;

    public function __construct(RestaurantRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list()
    {
        return $this->repository->findAllRestaurants();
    }
}