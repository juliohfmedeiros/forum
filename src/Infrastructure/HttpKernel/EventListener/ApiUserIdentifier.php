<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\HttpKernel\EventListener;

use App\Domain\UserManagement\User;
use App\Domain\UserManagement\UserIdentifier;

/**
 * ApiUserIdentifier
 *
 * @package App\Infrastructure\HttpKernel\EventListener
 */
final class ApiUserIdentifier implements UserIdentifier
{

    /**
     * @var User
     */
    private User $user;

    /**
     * Returns current logged in user
     *
     * @return null|User
     */
    public function currentUser(): ?User
    {
        return $this->user;
    }

    /**
     * Set current logged in user
     * @param User $user
     */
    public function withUser(User $user): void
    {
        $this->user = $user;
    }
}
