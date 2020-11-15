<?php


namespace App\Security\Voter;


use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{

    const USER_SHOW = "USER_SHOW";
    const USER_LIST = "USER_LIST";
    const USER_DELETE = "USER_DELETE";
    const USER_ADD_NOTE = "USER_ADD_NOTE";
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
        return in_array($attribute,[self::USER_LIST,self::USER_ADD_NOTE]) ||
            (in_array($attribute, [self::USER_SHOW, self::USER_DELETE])
                && $subject instanceof User);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }
        switch ($attribute) {
            case (
                self::USER_SHOW ||
                self::USER_DELETE
            ):
                return $this->security->isGranted("ROLE_ADMIN") ||
                    $subject === $user;
            case (self::USER_LIST ||
                self::USER_ADD_NOTE):
                return $this->security->isGranted("ROLE_ADMIN");
        }
        return false;
    }
}