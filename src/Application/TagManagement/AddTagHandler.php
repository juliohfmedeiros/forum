<?php

namespace App\Application\TagManagement;

use App\Application\Command;
use App\Application\CommandHandler;
use App\Domain\TagManagement\Tag;
use App\Domain\TagManagement\TagsRepository;
use Slick\Event\EventDispatcher;

class AddTagHandler implements CommandHandler
{
    /**
     * @var TagsRepository
     */
    private TagsRepository $tags;
    /**
     * @var EventDispatcher
     */
    private EventDispatcher $dispatcher;

    /**
     * Creates a AddTagHandler
     *
     * @param TagsRepository $tags
     * @param EventDispatcher $dispatcher
     */
    public function __construct(TagsRepository $tags, EventDispatcher $dispatcher)
    {
        $this->tags = $tags;
        $this->dispatcher = $dispatcher;
    }


    /**
     * Handle provide command
     *
     * @param Command|AddTagCommand $command
     * @return Tag
     */
    public function handle(Command $command)
    {
        $tag = new Tag(
            $command->description()
        );

        $this->dispatcher->dispatchEventsFrom(
            $this->tags->add($tag)
        );

        return $tag;
    }
}
