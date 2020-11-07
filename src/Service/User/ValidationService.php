<?php


namespace App\Service\User;


use App\Repository\TokenRepository;
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

    public function __construct(EntityManagerInterface $manager,
                                TokenRepository $tokenRepository)
    {

        $this->manager = $manager;
        $this->tokenRepository = $tokenRepository;;
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