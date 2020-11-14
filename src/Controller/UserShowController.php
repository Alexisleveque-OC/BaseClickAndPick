<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\User\ShowService;
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
     * @param ShowService $showService
     * @return Response
     */
    public function Show(User $user, ShowService $showService): Response
    {
        $user = $showService->findUser($user);

        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }
}
