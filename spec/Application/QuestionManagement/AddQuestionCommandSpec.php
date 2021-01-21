<?php

namespace spec\App\Application\QuestionManagement;

use App\Application\Command;
use App\Application\QuestionManagement\AddQuestionCommand;
use App\Domain\QuestionManagement\Question;
use App\Domain\UserManagement\User;
use PhpSpec\ObjectBehavior;

class AddQuestionCommandSpec extends ObjectBehavior
{
    private $title;
    private $body;

    function let(User $user)
    {
        $this->title = "Hello?";
        $this->body = "Hi!";

        $this->beConstructedWith($user, $this->title, $this->body);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AddQuestionCommand::class);
    }

    function its_a_command()
    {
        $this->shouldBeAnInstanceOf(Command::class);
    }

    function it_has_a_title()
    {
        $this->title()->shouldBe($this->title);
    }

    function it_has_a_body()
    {
        $this->body()->shouldBe($this->body);
    }

    function it_has_a_user(User $user)
    {
        $this->owner()->shouldBe($user);
    }
}
