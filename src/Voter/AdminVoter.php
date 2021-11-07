<?php


namespace App\Voter;


use App\Entity\User;
use App\Service\Constants;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;


class AdminVoter extends Voter
{
    private Security $security;
    public const VIEW = 'VIEW';

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        return $subject instanceof User && in_array(
                $attribute,
                [self::VIEW],
                true);
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $this->security->getUser();
        if ($user === null) {
            return false;
        }
        return match ($attribute) {
            self::VIEW => $this->canView(),
            default => false,
        };
    }

    private function canView(): bool
    {
        return $this->isAdmin();
    }

    private function isAdmin(): bool
    {
        return $this->security->isGranted(Constants::ROLE_ADMIN);
    }


}