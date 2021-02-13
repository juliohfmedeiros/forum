<?php

namespace spec\App\Domain\TagManagement\Tag\Events;

use App\Domain\TagManagement\Tag;
use App\Domain\TagManagement\Tag\Events\TagWasAdded;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

class TagWasAddedSpec extends ObjectBehavior
{

    private $description;

    function let(Tag $tag)
    {
        $this->description = "after";

        $tag->description()->willReturn($this->description);

        $this->beConstructedWith($tag);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TagWasAdded::class);
    }

    function its_an_event()
    {
        $this->shouldBeAnInstanceOf(Event::class);
        $this->shouldHaveType(AbstractEvent::class);
        $this->occurredOn()->shouldBeAnInstanceOf(\DateTimeImmutable::class);
    }

    function it_has_a_description()
    {
        $this->description()->shouldBe($this->description);
    }
}
