<?php

namespace App\Domain\UserManagement\User;

use App\Domain\Stringable;

/**
 * Password
 *
 * @package App\Domain\UserManagement\User
 */
final class Password implements Stringable
{

    /**
     * @var string
     */
    private $hash;

    public function __construct(string $password = null)
    {
        $this->hash = $this->hash($password);
    }

    /**
     * Creates a password from its hash
     *
     * @param string $hash
     *
     * @return Password
     */
    public static function fromHash(string $hash): Password
    {
        $password = new Password();
        $password->hash = $hash;
        return $password;
    }

    /**
     * Check if provided password match against current hash
     *
     * @param string $password
     *
     * @return bool
     */
    public function match(string $password): bool
    {
        return password_verify($password, $this->hash);
    }

    /**
     * Hashes the provided password
     *
     * @param string $password
     *
     * @return string
     */
    private function hash(?string $password): string
    {
        return password_hash($password, PASSWORD_ARGON2I);
    }

    /**
     * Returns a text version of the object
     *
     * @return string
     */
    public function __toString()
    {
        return $this->hash;
    }
}

