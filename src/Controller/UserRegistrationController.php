<?php

namespace App\Controller;

use App\Form\UserRegisterType;
use App\Service\User\RegisterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserRegistrationController extends AbstractController
{
    /**
     * @Route("/users/registration", name="users_registration")
     * @param Request $request
     * @param RegisterService $registerService
     * @return Response
     */
    public function index(Request $request, RegisterService $registerService): Response
    {
        $form = $this->createForm(UserRegisterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            echo ('coucou');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
