<?php


namespace App\Service\User;


use App\Repository\TokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPassService
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
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $encoder;

    public function __construct(EntityManagerInterface $manager,
                                TokenRepository $tokenRepository,
                                UserPasswordEncoderInterface $encoder)
    {
        $this->manager = $manager;
        $this->tokenRepository = $tokenRepository;
        $this->encoder = $encoder;
    }

    public function resetPass(string $token, string $newPass)
    {
        $token = $this->tokenRepository->findOneByToken($token);
        $token = $token[0];
        $user = $token->getUser();

        $hash = $this->encoder->encodePassword($user, $newPass);
        $user->setPassword($hash);

        $this->manager->persist($user);
        $this->manager->flush();

        return $user;
    }
}