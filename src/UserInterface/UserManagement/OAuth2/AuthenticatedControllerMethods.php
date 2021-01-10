<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\UserInterface\UserManagement\OAuth2;

use App\Domain\UserManagement\User;

/**
 * AuthenticatedControllerMethods trait
 *
 * @package App\UserInterface\UserManagement\OAuth2
 */
trait AuthenticatedControllerMethods
{

    protected $currentUser;

    /**
     * Current logged in user
     *
     * @return User
     */
    public function currentUser(): User
    {
        return $this->currentUser;
    }

    /**
     * Set current working user
     *
     * @param User $user
     *
     * @return AuthenticatedControllerInterface|$this
     */
    public function withCurrentUser(User $user): AuthenticatedControllerInterface
    {
        $this->currentUser = $user;
        return $this;
    }
}
