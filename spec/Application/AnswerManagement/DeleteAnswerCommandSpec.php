<?php

namespace spec\App\Application\AnswerManagement;

use App\Application\Command;
use App\Application\AnswerManagement\DeleteAnswerCommand;
use App\Domain\AnswerManagement\Answer\AnswerId;
use PhpSpec\ObjectBehavior;

class DeleteAnswerCommandSpec extends ObjectBehavior
{
    private $answerId;

    function let()
    {
        $this->answerId = new AnswerId();
        $this->beConstructedWith($this->answerId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DeleteAnswerCommand::class);
    }

    function its_a_command()
    {
        $this->shouldBeAnInstanceOf(Command::class);
    }

    function it_has_a_answerId()
    {
        $this->answerId()->shouldBe($this->answerId);
    }
}
