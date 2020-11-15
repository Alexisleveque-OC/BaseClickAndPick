<?php


namespace App\Service\User;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class AddNoteService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function addNote(User $user)
    {
        $this->manager->persist($user);
        $this->manager->flush();

        return $user;
    }
}