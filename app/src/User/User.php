<?php

namespace App\User;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    private $username;
    private $password;

    public function __construct(string $username, string $password, string $roles)
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('No username provided.');
        }

        $this->username = $username;
        $this->password = $password;
        $this->roles = $roles;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return '';
    }

    public function eraseCredentials()
    {
    }

    public function getRoles(): array
    {
        return ['API_USER'];
    }

    public function getUserIdentifier(): string
    {
        return 'email';
    }
}
