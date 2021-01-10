<?php

namespace App\Application\UserManagement;

use App\Application\Command;
use App\Application\CommandHandler;
use App\Domain\UserManagement\User;
use App\Domain\UserManagement\UsersRepository;
use Exception;

/**
 * CreateUserHandler
 *
 * @package App\Application\UserManagement
 */
final class CreateUserHandler implements CommandHandler
{
    /**
     * @var UsersRepository
     */
    private $usersRepository;

    /**
     * Creates a CreateUserHandler
     *
     * @param UsersRepository $usersRepository
     */
    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * @param CreateUserCommand|Command $command
     * @return User
     * @throws Exception
     */
    public function handle(Command $command): User
    {
        $user = new User($command->name(), $command->email(), $command->password());
        return $this->usersRepository->add($user);
    }
}

