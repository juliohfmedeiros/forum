<?php

namespace spec\App\Application\TagManagement;

use App\Application\Command;
use App\Application\TagManagement\UpdateTagCommand;
use App\Domain\AnswerManagement\Answer\AnswerId;
use PhpSpec\ObjectBehavior;

class UpdateTagCommandSpec extends ObjectBehavior
{

    private $description;

    function let()
    {
        $this->description = 'updated time';
        $this->beConstructedWith($this->description);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(UpdateTagCommand::class);
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
