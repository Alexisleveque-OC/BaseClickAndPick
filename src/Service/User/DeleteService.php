<?php


namespace App\Service\User;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class DeleteService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function deleteUser(User $user)
    {
        $user->setDeleted(true)
            ->setValidated(false);
        $token = $user->getToken();
        $newToken= $token->generateToken();
        $token->setToken($newToken);

        $this->manager->persist($user);
        $this->manager->flush();
    }

}