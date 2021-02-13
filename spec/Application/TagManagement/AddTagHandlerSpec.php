<?php

namespace spec\App\Application\TagManagement;

use App\Application\CommandHandler;
use App\Application\TagManagement\AddTagCommand;
use App\Application\TagManagement\AddTagHandler;
use App\Domain\TagManagement\Tag;
use App\Domain\TagManagement\TagsRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slick\Event\EventDispatcher;

class AddTagHandlerSpec extends ObjectBehavior
{

    function let(TagsRepository $tags, EventDispatcher $dispatcher)
    {
        /** @var Tag $newTag */
        $newTag = Argument::type(Tag::class);
        $dispatcher->dispatchEventsFrom($newTag)->willReturn([]);

        $tags->add($newTag)->willReturnArgument(0);

        $this->beConstructedWith($tags, $dispatcher);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(AddTagHandler::class);
    }

    function its_a_command_handler()
    {
        $this->shouldBeAnInstanceOf(CommandHandler::class);
    }

    function it_handles_add_tag_command(TagsRepository $tags, EventDispatcher $dispatcher)
    {
        $command = new AddTagCommand(
            'time'
        );

        $tag = $this->handle($command);
        $tag->shouldBeAnInstanceOf(Tag::class);

        $tags->add($tag)->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($tag)->shouldHaveBeenCalled();
    }
}
