<?php


namespace App\Security\Voter;


use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class MealVoter extends Voter
{
    const MENU_EDIT = "MENU_EDIT";
    const MEAL_CREATE = "MEAL_CREATE";
    /**
     * @var Security
     */
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject)
    {
        return in_array($attribute,[self::MENU_EDIT,self::MEAL_CREATE]);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }
        switch ($attribute){
            case (
                self::MENU_EDIT ||
                self::MEAL_CREATE
            ):
                return $this->security->isGranted("ROLE_ADMIN");
        }
        return false;
    }
}