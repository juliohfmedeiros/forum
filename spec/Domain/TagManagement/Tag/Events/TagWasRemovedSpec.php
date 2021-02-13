<?php

namespace spec\App\Domain\TagManagement\Tag\Events;

use App\Domain\TagManagement\Tag\Events\TagWasRemoved;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

class TagWasRemovedSpec extends ObjectBehavior
{
    private string $description;

    function let()
    {
        $this->description = "time";
        $this->beConstructedWith($this->description);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(TagWasRemoved::class);
    }

    function its_an_event()
    {
        $this->shouldBeAnInstanceOf(Event::class);
        $this->shouldHaveType(AbstractEvent::class);
        $this->occurredOn()->shouldBeAnInstanceOf(\DateTimeImmutable::class);
    }

    function it_has_a_answerId()
    {
        $this->description()->shouldBe($this->description);
    }
}
