<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserValidationController extends AbstractController
{
    /**
     * @Route("/user/validation", name="user_validation")
     */
    public function index(): Response
    {
        return $this->render('user_validation/index.html.twig', [
            'controller_name' => 'UserValidationController',
        ]);
    }
}
