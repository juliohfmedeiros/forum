<?php

namespace spec\App\Application\QuestionManagement;

use App\Application\Command;
use App\Application\QuestionManagement\EditQuestionCommand;
use App\Domain\QuestionManagement\Question\QuestionId;
use PhpSpec\ObjectBehavior;

class EditQuestionCommandSpec extends ObjectBehavior
{

    private $questionId;
    private $title;
    private $body;

    function let()
    {
        $this->questionId = new QuestionId();
        $this->title = 'Changed title';
        $this->body = 'Changed body';
        $this->beConstructedWith($this->questionId, $this->title, $this->body);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(EditQuestionCommand::class);
    }

    function its_a_command()
    {
        $this->shouldBeAnInstanceOf(Command::class);
    }

    function it_has_a_questionId()
    {
        $this->questionId()->shouldBe($this->questionId);
    }

    function it_has_a_title()
    {
        $this->title()->shouldBe($this->title);
    }

    function it_has_a_body()
    {
        $this->body()->shouldBe($this->body);
    }
}
