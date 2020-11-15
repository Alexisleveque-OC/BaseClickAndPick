<?php


namespace App\Service\User;


use App\Repository\TokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

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
        if (isset($token[0])){
        $token = $token[0];
        }
        else{
            throw new Exception('Les informations envoyées ne sont pas valide.', 400);
        }

        $token->getUser()->setValidated(true);

        $this->manager->persist($token);
        $this->manager->flush();
    }
}