<?php


namespace App\Service\User;


use App\Repository\UserRepository;

class ListUsersService
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function listUsers()
    {
        return $this->userRepository->findAllByUsername();
    }
}