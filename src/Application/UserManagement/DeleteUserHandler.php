<?php

namespace App\Application\UserManagement;

use App\Application\Command;
use App\Application\CommandHandler;
use App\Domain\UserManagement\UsersRepository;

/**
 * DeleteUserHandler
 *
 * @package App\Application\UserManagement
 */
final class DeleteUserHandler implements CommandHandler
{
    /**
     * @var UsersRepository
     */
    private UsersRepository $usersRepository;

    /**
     * Creates a DeleteUserHandler
     *
     * @param UsersRepository $usersRepository
     */
    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * handle
     *
     * @param DeleteUserCommand|Command $command
     */
    public function handle(Command $command): void
    {
        $user = $this->usersRepository->withEmail($command->email());
        $this->usersRepository->remove($user);
    }
}
