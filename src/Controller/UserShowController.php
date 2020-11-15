<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ConfirmationDeleteType;
use App\Form\UserAddNoteType;
use App\Service\User\UserFinderService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserShowController extends AbstractController
{
    /**
     * @Route("/user/show/{id}", name="user_show")
     * @IsGranted("USER_SHOW",subject="user")
     * @param User $user
     * @param UserFinderService $userFinder
     * @return Response
     */
    public function Show(User $user, UserFinderService $userFinder): Response
    {
        $formDelete = $this->createForm(ConfirmationDeleteType::class);
        $formAddNote = $this->createForm(UserAddNoteType::class,$user);

        $user = $userFinder->findUserById($user);

        return $this->render('user/show.html.twig', [
            'user' => $user,
            'formDelete' => $formDelete->createView(),
            'formAddNote' =>$formAddNote->createView(),
        ]);
    }
}
