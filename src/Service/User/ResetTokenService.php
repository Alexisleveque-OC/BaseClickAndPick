<?php


namespace App\Service\User;


use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class ResetTokenService
{

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    public function __construct(EntityManagerInterface $manager, UserRepository $userRepository)
    {

        $this->manager = $manager;
        $this->userRepository = $userRepository;
    }
    public function resetToken($form)
    {
        $email = $form['email'];
        $user = $this->userRepository->findOneByEmail($email);
        $user = $user[0];

        $newToken = $user->getToken()->generateToken();
        $user->getToken()->setToken($newToken);

        $this->manager->persist($user);
        $this->manager->flush();

        return $user;
    }
}