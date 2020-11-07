<?php

namespace App\Controller;

use App\Service\User\ValidationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserValidationController extends AbstractController
{
    /**
     * @Route("/users/validation/{token}", name="user_validation")
     * @param string $token
     * @param ValidationService $validationService
     * @return Response
     */
    public function validation(string $token, ValidationService $validationService): Response
    {
        $validationService->validate($token);

        $this->addFlash('success', 'Votre compte a été correctement validé !!!');

        return $this->render('security/accountValidated.html.twig');
    }
}
