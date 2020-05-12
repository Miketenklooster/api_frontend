<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @author Mike ten Klooster <mike.tenklooster001@fclive.nl> <226751> <25187> <Applicatie Ontwikkeling>
 * @version 8
 *
 * Class Token
 * @package App\Security
 */
class Token
{
    /**
     * @param UserInterface $user
     * @return string
     * @throws \Exception
     */
    public function generate(UserInterface $user)
    {
        $header  = [
            "alg" => "HS256",
            "typ" => "JWT"
        ];

        $payload = [
            "email"             => $user->getEmail(),
            "roles"             => $user->getRoles(),
            "created_at"        => $user->getCreatedAt(),
            "token_expires_at"  => $user->getTokenExpiresAt(),
            "current_time"      => new \DateTime('now')
        ];

        return base64_encode(json_encode($header) . "." . json_encode($payload));
    }
}
