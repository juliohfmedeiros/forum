<?php

namespace spec\App\Application\AnswerManagement;

use App\Application\Command;
use App\Application\AnswerManagement\GiveAnswerCommand;
use App\Domain\AnswerManagement\Answer;
use App\Domain\UserManagement\User;
use PhpSpec\ObjectBehavior;

class GiveAnswerCommandSpec extends ObjectBehavior
{
    private $description;

    function let(User $user)
    {
        $this->description = "now";

        $this->beConstructedWith($user, $this->description);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GiveAnswerCommand::class);
    }

    function its_a_command()
    {
        $this->shouldBeAnInstanceOf(Command::class);
    }

    function it_has_a_description()
    {
        $this->description()->shouldBe($this->description);
    }

    function it_has_a_user(User $user)
    {
        $this->owner()->shouldBe($user);
    }
}
