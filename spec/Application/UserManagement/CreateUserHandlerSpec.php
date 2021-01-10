<?php

namespace spec\App\Application\UserManagement;

use App\Application\CommandHandler;
use App\Application\UserManagement\CreateUserCommand;
use App\Application\UserManagement\CreateUserHandler;
use App\Domain\UserManagement\User;
use App\Domain\UserManagement\UsersRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreateUserHandlerSpec extends ObjectBehavior
{
    function let(UsersRepository $repository)
    {
        $repository->add(Argument::type(User::class))->willReturnArgument(0);
        $this->beConstructedWith($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CreateUserHandler::class);
    }

    function its_a_command_handler()
    {
        $this->shouldBeAnInstanceOf(CommandHandler::class);
    }

    function it_handles_the_create_user_command(UsersRepository $repository)
    {
        $passwdStr = '234567';
        $password = new User\Password($passwdStr);
        $email = new User\Email('jane.doe@example.com');
        $name = 'Jane Doe';
        $command = new CreateUserCommand($name, $email, $password);

        $user = $this->handle($command);
        $user->shouldBeAnInstanceOf(User::class);
        $repository->add($user)->shouldHaveBeenCalled();
    }

}
