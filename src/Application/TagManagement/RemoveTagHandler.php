<?php

namespace App\Application\TagManagement;

use App\Application\Command;
use App\Application\CommandHandler;
use App\Domain\TagManagement\Tag;
use App\Domain\TagManagement\TagsRepository;
use Slick\Event\EventDispatcher;

class RemoveTagHandler implements CommandHandler
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
     * Creates a RemoveTagHandler
     *
     * @param TagsRepository $tags
     * @param EventDispatcher $dispatcher
     */
    public function __construct(
        TagsRepository $tags,
        EventDispatcher $dispatcher
    ) {
        $this->tags = $tags;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Handle provide command
     *
     * @param Command|RemoveTagCommand $command
     * @return Tag
     */
    public function handle(Command $command): Tag
    {
        $tag = $this->tags->withDescription($command->description());

        $this->tags->remove($tag);
        $this->dispatcher->dispatchEventsFrom($tag);
        return $tag;
    }
}
