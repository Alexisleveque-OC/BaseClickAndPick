<?php


namespace App\Security\Voter;


use App\Entity\Meal;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class MealVoter extends Voter
{
    const MENU_EDIT = "MENU_EDIT";
    const MEAL_CREATE = "MEAL_CREATE";
    const MEAL_EDIT = "MEAL_EDIT";
    const MEAL_DELETE = "MEAL_DELETE";
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
        return in_array($attribute,[self::MENU_EDIT,self::MEAL_CREATE]) ||
            (in_array($attribute,[self::MEAL_DELETE, self::MEAL_EDIT])
            && $subject instanceof Meal);
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
                self::MEAL_CREATE ||
                self::MEAL_EDIT ||
                self::MEAL_DELETE
            ):
                return $this->security->isGranted("ROLE_ADMIN");

        }
        return false;
    }
}