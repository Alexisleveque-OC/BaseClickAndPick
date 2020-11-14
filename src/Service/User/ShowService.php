<?php


namespace App\Service\User;


use App\Entity\User;
use App\Repository\UserRepository;

class ShowService
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function findUser(User $user)
    {
        $user = $this->userRepository->findOneById($user->getId());

        return $user[0];
    }
}