<?php


namespace App\Service\Meal;


use App\Repository\CategoryRepository;
use App\Repository\MealRepository;

class ListCategoriesService
{


    /**
     * @var CategoryRepository
     */
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function listCategories()
    {
        return $this->categoryRepository->findAllCategories();
    }
}