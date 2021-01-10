<?php

namespace spec\App\Application\UserManagement;

use App\Application\Command;
use App\Application\UserManagement\CreateUserCommand;
use App\Domain\UserManagement\User\Email;
use App\Domain\UserManagement\User\Password;
use PhpSpec\ObjectBehavior;

class CreateUserCommandSpec extends ObjectBehavior
{
    private $password;
    private $email;
    private $name;

    function let()
    {
        $this->password = new Password('23456');
        $this->email = new Email('john.doe@example.com');
        $this->name = 'John Doe';

        $this->beConstructedWith($this->name, $this->email, $this->password);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CreateUserCommand::class);
    }

    function its_a_command()
    {
        $this->shouldBeAnInstanceOf(Command::class);
    }

    function it_has_a_name()
    {
        $this->name()->shouldBe($this->name);
    }

    function it_has_an_email()
    {
        $this->email()->shouldBe($this->email);
    }

    function it_has_a_password()
    {
        $this->password()->shouldBe($this->password);
    }

    function it_can_be_constructed_without_password()
    {
        $this->beConstructedWith($this->name, $this->email);
        $this->password()->shouldBeAnInstanceOf(Password::class);
    }

}
