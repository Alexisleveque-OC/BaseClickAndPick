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
        return (in_array($attribute,[self::USER_SHOW])
                && $subject instanceof User);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }
        switch ($attribute){
            case (
                self::USER_SHOW
            ):
                return $this->security->isGranted("ROLE_ADMIN") ||
                    $subject === $user;

        }
        return false;
    }
}