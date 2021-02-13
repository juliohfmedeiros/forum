<?php

namespace spec\App\Application\QuestionManagement;

use App\Application\Command;
use App\Application\QuestionManagement\DeleteQuestionCommand;
use App\Domain\QuestionManagement\Question\QuestionId;
use PhpSpec\ObjectBehavior;

class DeleteQuestionCommandSpec extends ObjectBehavior
{
    private $questionId;

    function let()
    {
        $this->questionId = new QuestionId();
        $this->beConstructedWith($this->questionId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DeleteQuestionCommand::class);
    }

    function its_a_command()
    {
        $this->shouldBeAnInstanceOf(Command::class);
    }

    function it_has_a_questionId()
    {
        $this->questionId()->shouldBe($this->questionId);
    }
}
