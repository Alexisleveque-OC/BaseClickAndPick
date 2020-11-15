<?php


namespace App\Service\User;


use App\Entity\User;
use App\Repository\UserRepository;

class UserFinderService
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function findUserById(User $user)
    {
        $user = $this->userRepository->findOneById($user->getId());

        return $user[0];
    }
    public function findUserByEmail(User $user)
    {
        $user = $this->userRepository->findOneByEmail($user->getEmail());

        return $user;
    }
}