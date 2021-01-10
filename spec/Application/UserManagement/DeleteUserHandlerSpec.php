<?php

namespace spec\App\Application\UserManagement;

use App\Application\CommandHandler;
use App\Application\UserManagement\DeleteUserCommand;
use App\Application\UserManagement\DeleteUserHandler;
use App\Domain\UserManagement\User;
use App\Domain\UserManagement\User\Email;
use App\Domain\UserManagement\UsersRepository;
use PhpSpec\ObjectBehavior;

class DeleteUserHandlerSpec extends ObjectBehavior
{
    private $email;

    function let(
        UsersRepository $repository,
        User $user
    ) {
        $this->email = new Email('john.doe@mail.us');
        $repository->withEmail($this->email)->willReturn($user);

        $this->beConstructedWith($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DeleteUserHandler::class);
    }

    function its_a_command_handler()
    {
        $this->shouldBeAnInstanceOf(CommandHandler::class);
    }

    function it_handles_delete_user_command(
        UsersRepository $repository,
        User $user
    ) {
        $command = new DeleteUserCommand($this->email);
        $repository->remove($user)->shouldBeCalled();

        $this->handle($command);
    }

}
