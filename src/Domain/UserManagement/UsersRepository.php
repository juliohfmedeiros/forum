<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\UserManagement;

use App\Domain\UserManagement\User\Email;
use App\Domain\UserManagement\User\UserId;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;

/**
 * UsersRepository
 *
 * @package App\Domain\UserManagement
 */
interface UsersRepository extends UserRepositoryInterface
{
    /**
     * Adds an user to the repository
     *
     * @param User $user
     * @return User
     */
    public function add(User $user): User;

    /**
     * Persists user changes
     *
     * @param User $user
     * @return User
     */
    public function update(User $user): User;

    /**
     * Removes user from repository
     *
     * @param User $user
     */
    public function remove(User $user): void;

    /**
     * Retrieves the user with provided userId
     *
     * @param UserId $userId
     * @return User
     *
     * @throws \RuntimeException if user is not found
     */
    public function withUserId(UserId $userId): User;

    /**
     * Retrieves the user with provided email
     *
     * @param Email $email
     * @return User
     *
     * @throws \RuntimeException if user is not found
     */
    public function withEmail(Email $email): User;
}
