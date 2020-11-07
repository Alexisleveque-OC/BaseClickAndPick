<?php


namespace App\Service\User;


use App\Entity\Token;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterService
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $encoder;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    public function __construct(UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager)
    {

        $this->encoder = $encoder;
        $this->manager = $manager;
    }

    public function register(User $user)
    {
        $hash = $this->encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($hash)
            ->setCreatedAt(new \DateTime())
            ->setRoles(['ROLE_USER'])
            ->setAddress($user->getAddress())
            ->setValidated(false);
        $this->manager->persist($user);

        $token = new Token();
        $token->setUser($user);
        $this->manager->persist($token);

        $this->manager->flush();

        return $token;
    }
}