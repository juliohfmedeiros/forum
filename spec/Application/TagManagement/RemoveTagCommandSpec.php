<?php

namespace spec\App\Application\TagManagement;

use App\Application\Command;
use App\Application\TagManagement\RemoveTagCommand;
use PhpSpec\ObjectBehavior;

class RemoveTagCommandSpec extends ObjectBehavior
{
    private $description;

    function let()
    {
        $this->description = "after";
        $this->beConstructedWith($this->description);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(RemoveTagCommand::class);
    }

    function its_a_command()
    {
        $this->shouldBeAnInstanceOf(Command::class);
    }

    function it_has_a_description()
    {
        $this->description()->shouldBe($this->description);
    }
}
