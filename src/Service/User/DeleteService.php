<?php


namespace App\Service\User;


use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeleteService
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

    public function deleteUser(User $user)
    {
        if ($user->getRestaurant() != null) {
            $usersLinkedToRestaurant = $this->userRepository->findAllUsersLinkedToRestaurantAndNotDeleted();
            if (count($usersLinkedToRestaurant) === 1) {
                throw new \Exception('Vous essayez de supprimer le dernier administrateur du site, vous ne pourrez plus gérer votre site.
                Contactez le développeur du site pour plus d\'informations.');
            }
        }
        $user->setDeleted(true)
            ->setValidated(false);
        $token = $user->getToken();
        $newToken = $token->generateToken();
        $token->setToken($newToken);

        $this->manager->persist($user);
        $this->manager->flush();
    }

}