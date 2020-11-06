<?php


namespace App\Service\User;


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
        $hash = $this->encoder->encodePassword($user , $user->getPassword());
        $user->setPassword($hash)
            ->setCreatedAt(new \DateTime())
            ->setRoles(['ROLE_USER'])
            ->setAddress($user->getAddress());
        //TODO:placer la création du token ici
        $this->manager->persist($user);
        $this->manager->flush();

        return $user;
    }
}