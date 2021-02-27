<?php

namespace App\Security;

use App\Entity\Member as AppUser;
use App\Exception\AccountDeletedException;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

// Documentation : https://symfony.com/doc/current/security/user_checkers.html
// Lors de l'authentification d'un utilisateur, des vérifications supplémentaires peuvent être nécessaires pour vérifier si l'utilisateur identifié est autorisé à se connecter. En définissant un vérificateur d'utilisateur personnalisé, vous pouvez définir par pare-feu quel vérificateur doit être utilisé

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            return;
        }

        if (!$user->getValidation()) {
            throw new CustomUserMessageAccountStatusException(
                "COMPTE EN ATTENTE DE CONFIRMATION"
            );
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            return;
        }
    } 

}