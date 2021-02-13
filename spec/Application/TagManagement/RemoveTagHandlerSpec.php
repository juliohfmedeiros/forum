<?php

namespace spec\App\Application\TagManagement;

use App\Application\CommandHandler;
use App\Application\TagManagement\RemoveTagCommand;
use App\Application\TagManagement\RemoveTagHandler;
use App\Domain\Exception\FailedEntitySpecification;
use App\Domain\TagManagement\Tag;
use App\Domain\TagManagement\TagsRepository;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventDispatcher;

class RemoveTagHandlerSpec extends ObjectBehavior
{
    private string $description;

    function let(
        TagsRepository $tags,
        EventDispatcher $dispatcher,
        Tag $tag
    ) {

        $this->description = 'time';
        $tags->withDescription($this->description)->willReturn($tag);

        $dispatcher->dispatchEventsFrom($tag)->willReturn([]);

        $this->beConstructedWith($tags, $dispatcher);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(RemoveTagHandler::class);
    }


    function its_a_command_handler()
    {
        $this->shouldBeAnInstanceOf(CommandHandler::class);
    }

    function it_handles_delete_tag_command(
        TagsRepository $tags,
        EventDispatcher $dispatcher,
        Tag $tag
    ) {
        $command = new RemoveTagCommand(
            $this->description
        );

        $this->handle($command)->shouldBe($tag);

        $tags->remove($tag)->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($tag)->shouldHaveBeenCalled();
    }


}
