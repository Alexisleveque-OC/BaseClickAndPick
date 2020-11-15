<?php

namespace App\Controller;

use App\Form\UserRegisterType;
use App\Service\Mail\Mailer;
use App\Service\User\RegisterService;
use App\Service\User\UserFinderService;
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
     * @param Mailer $mailer
     * @param UserFinderService $userFinder
     * @return Response
     */
    public function index(Request $request,
                          RegisterService $registerService,
                          Mailer $mailer,
                          UserFinderService $userFinder): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }
        $form = $this->createForm(UserRegisterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newUser = $form->getData();

            $user = $userFinder->findUserByEmail($newUser);
            if (isset($user[0])) {
                $token = $registerService->registerIfUserDeleted($user[0], $newUser);
            } else {
                $token = $registerService->register($newUser);
            }

            $mailer->sendUserTokenMail($token);

            $this->addFlash('success', 'Vous avez été enregistré, vérifiez vos email pour valider votre compte !');
            return $this->redirectToRoute('home');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
