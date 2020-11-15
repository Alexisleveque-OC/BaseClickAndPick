<?php

namespace App\Controller;

use App\Entity\User;
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
     * @Route("/users/edit/{id}", name="user_edit")
     * @param Request $request
     * @param RegisterService $registerService
     * @param Mailer $mailer
     * @param UserFinderService $userFinder
     * @param User $user
     * @return Response
     */
    public function RegisterUser(Request $request,
                                 RegisterService $registerService,
                                 Mailer $mailer,
                                 UserFinderService $userFinder,
                                 User $user = null): Response
    {
        if ($this->getUser() && $user == null) {
            return $this->redirectToRoute('home');
        }
        if (!$user) {
            $user = new User();
        }
        if ($user) {
            $editMode = true;
        }
        $form = $this->createForm(UserRegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newUser = $form->getData();

            $userFound = $userFinder->findUserByEmail($newUser);

            if (isset($userFound[0]) && $userFound[0]->getDeleted() == true) {
                $userFound = $userFound[0];

                $token = $registerService->registerIfUserDeleted($userFound, $newUser);

            } elseif (isset($userFound[0])) {
                $userFound = $userFound[0];

                $registerService->editUser($userFound);

                $this->addFlash('success', "Vos informations ont été correctement modifié.");

                return $this->redirectToRoute('user_show', ['id' => $userFound->getId()]);

            } else {
                $token = $registerService->register($newUser);
            }

            $mailer->sendUserTokenMail($token);

            $this->addFlash('success', 'Vous avez été enregistré, vérifiez vos email pour valider votre compte !');
            return $this->redirectToRoute('home');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
            'editMode' => $editMode,
        ]);
    }
}
