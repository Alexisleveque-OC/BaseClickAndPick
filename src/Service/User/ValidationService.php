<?php


namespace App\Service\User;


use App\Entity\Token;
use App\Repository\TokenRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class ValidationService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;
    /**
     * @var TokenRepository
     */
    private TokenRepository $tokenRepository;
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    public function __construct(EntityManagerInterface $manager,
                                TokenRepository $tokenRepository,
                                UserRepository $userRepository)
    {

        $this->manager = $manager;
        $this->tokenRepository = $tokenRepository;
        $this->userRepository = $userRepository;
    }

    public function validate(string $tokenValue)
    {
        $token = $this->tokenRepository->findOneByToken($tokenValue);
        $token = $token[0];

        $token->getUser()->setValidated(true);

        $this->manager->persist($token);
        $this->manager->flush();
    }
}