<?php

namespace App\Application\UserManagement;

use App\Application\Command;
use App\Domain\UserManagement\User\Email;

/**
 * DeleteUserCommand
 *
 * @package App\Application\UserManagement
 */
final class DeleteUserCommand implements Command
{
    /**
     * @var Email
     */
    private $email;

    /**
     * Creates a DeleteUserCommand
     *
     * @param Email $email
     */
    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    public function email(): Email
    {
        return $this->email;
    }

}
