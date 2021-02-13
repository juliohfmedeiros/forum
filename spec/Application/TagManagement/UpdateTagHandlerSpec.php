<?php

namespace spec\App\Application\TagManagement;

use App\Application\TagManagement\UpdateTagCommand;
use App\Domain\TagManagement\Tag;
use App\Domain\TagManagement\TagsRepository;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventDispatcher;

class UpdateTagHandlerSpec extends ObjectBehavior
{

    private string $description;

    function let(
        TagsRepository $tags,
        EventDispatcher $dispatcher,
        Tag $tag
    ) {

        $this->description = "updated time";
        $tags->withDescription($this->description)->willReturn($tag);


        $tags->update($tag)->willReturnArgument(0);

        $dispatcher->dispatchEventsFrom($tag)->willReturn([]);

        $this->beConstructedWith($tags, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UpdateTagHandler::class);
    }

    function its_a_command_handler()
    {
        $this->shouldBeAnInstanceOf(CommandHandler::class);
    }

    function it_handles_update_tag_command(
        TagsRepository $tags,
        EventDispatcher $dispatcher,
        Tag $tag
    ) {
        $command = new UpdateTagCommand(
            $this->description
        );

        $this->handle($command)->shouldBe($tag);

        $tags->update($tag)->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($tag)->shouldHaveBeenCalled();
    }
}
