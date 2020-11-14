<?php

namespace App\Controller;

use App\Service\User\ListUsersService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserListController extends AbstractController
{
    /**
     * @Route("/users", name="user_list")
     * @IsGranted("USER_LIST")
     * @param ListUsersService $listUsers
     * @return Response
     */
    public function listUsers(ListUsersService $listUsers): Response
    {
        $users = $listUsers->listUsers();

        return $this->render('user/list.html.twig', [
            'users' => $users,
        ]);
    }
}
