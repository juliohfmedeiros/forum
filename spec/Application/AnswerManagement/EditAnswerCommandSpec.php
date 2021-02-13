<?php

namespace spec\App\Application\AnswerManagement;

use App\Application\Command;
use App\Application\AnswerManagement\EditAnswerCommand;
use App\Domain\AnswerManagement\Answer\AnswerId;
use PhpSpec\ObjectBehavior;

class EditAnswerCommandSpec extends ObjectBehavior
{

    private $answerId;
    private $description;

    function let()
    {
        $this->answerId = new AnswerId();
        $this->description = 'Changed title';
        $this->beConstructedWith($this->answerId, $this->description);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(EditAnswerCommand::class);
    }

    function its_a_command()
    {
        $this->shouldBeAnInstanceOf(Command::class);
    }

    function it_has_a_answerId()
    {
        $this->answerId()->shouldBe($this->answerId);
    }

    function it_has_a_description()
    {
        $this->description()->shouldBe($this->description);
    }

}
