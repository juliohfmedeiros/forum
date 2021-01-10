<?php

namespace spec\App\Application\UserManagement;

use App\Application\Command;
use App\Application\UserManagement\DeleteUserCommand;
use App\Domain\UserManagement\User\Email;
use PhpSpec\ObjectBehavior;

class DeleteUserCommandSpec extends ObjectBehavior
{
    private $email;

    function let()
    {
        $this->email = new Email('jo@mail.us');
        $this->beConstructedWith($this->email);
    }

    function its_a_command()
    {
        $this->shouldBeAnInstanceOf(Command::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DeleteUserCommand::class);
    }

    function it_has_an_email()
    {
        $this->email()->shouldBe($this->email);
    }

}
