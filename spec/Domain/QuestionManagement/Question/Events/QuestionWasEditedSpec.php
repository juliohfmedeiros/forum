<?php

namespace spec\App\Domain\QuestionManagement\Question\Events;

use App\Domain\QuestionManagement\Question\Events\QuestionWasEdited;
use App\Domain\QuestionManagement\Question\QuestionId;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

class QuestionWasEditedSpec extends ObjectBehavior
{
    private $questionId;
    private $title;
    private $body;

    function let()
    {
        $this->questionId = new QuestionId();
        $this->title = "new title";
        $this->body = "new body";
        $this->beConstructedWith(
            $this->questionId,
            $this->title,
            $this->body
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(QuestionWasEdited::class);
    }

    function its_an_event()
    {
        $this->shouldBeAnInstanceOf(Event::class);
        $this->shouldHaveType(AbstractEvent::class);
        $this->occurredOn()->shouldBeAnInstanceOf(\DateTimeImmutable::class);
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
