<?php

namespace spec\App\Domain\QuestionManagement\Question\Events;

use App\Domain\QuestionManagement\Question\Events\QuestionWasDeleted;
use App\Domain\QuestionManagement\Question\QuestionId;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

class QuestionWasDeletedSpec extends ObjectBehavior
{
    private $questionId;

    function let()
    {
        $this->questionId = new QuestionId();
        $this->beConstructedWith($this->questionId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(QuestionWasDeleted::class);
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
}
