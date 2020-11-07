<?php

namespace App\Controller;

use App\Form\ForgotPassType;
use App\Service\Mail\Mailer;
use App\Service\User\ResetTokenService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserForgotPassController extends AbstractController
{
    /**
     * @Route("/users/forgotpass", name="user_forgot_pass")
     * @param Request $request
     * @param ResetTokenService $resetToken
     * @param Mailer $mailer
     * @return Response
     */
    public function forgotPass(Request $request, ResetTokenService $resetToken, Mailer $mailer): Response
    {
        $form = $this->createForm(ForgotPassType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user = $resetToken->resetToken($form->getData());

            $mailer->sendUserMailResetPass($user);

            $this->addFlash('success', 'Vous avez reçu un mail, validez votre email avant de continuer!');
            return $this->redirectToRoute('home');
        }

        return $this->render('security/forgotPass.html.twig', [
            'form'=> $form->createView()
        ]);
    }
}
