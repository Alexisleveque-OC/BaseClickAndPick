<?php

namespace App\Controller;

use App\Entity\Token;
use App\Form\NewPassType;
use App\Service\User\ResetPassService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserResetPassController extends AbstractController
{
    /**
     * @Route("/users/resetPass/{token}", name="user_reset_pass")
     * @param Request $request
     * @param string $token
     * @param ResetPassService $resetPass
     * @return Response
     */
    public function resetPass(Request $request, string $token, ResetPassService $resetPass): Response
    {
        $form = $this->createForm(NewPassType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $form = $form->getData();
            $newPass= $form['password'];

            $resetPass->resetPass($token, $newPass);

            $this->addFlash('success', 'Votre mot de passe a bien été modifié.');

            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/resetPass.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
