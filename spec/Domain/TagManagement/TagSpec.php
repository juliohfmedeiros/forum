<?php

namespace spec\App\Domain\TagManagement;

use App\Domain\TagManagement\Tag;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventGenerator;

class TagSpec extends ObjectBehavior
{
    private $description;

    function let()
    {
        $this->description = "now";
        $this->beConstructedWith($this->description);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Tag::class);
    }

    function its_an_event_generator()
    {
        $this->shouldBeAnInstanceOf(EventGenerator::class);
        $this->releaseEvents()[0]->shouldBeAnInstanceOf(Tag\Events\TagWasAdded::class);
    }

    function it_has_a_description()
    {
        $this->description()->shouldBe($this->description);
    }
}
