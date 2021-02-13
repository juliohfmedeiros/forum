<?php

namespace App\Application\TagManagement;

use App\Application\Command;
use App\Application\CommandHandler;
use App\Domain\TagManagement\Tag;
use App\Domain\TagManagement\TagsRepository;
use Slick\Event\EventDispatcher;

class UpdateTagHandler implements CommandHandler
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
     * Creates a UpdateTagHandler
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
     * @param Command|UpdateTagCommand $command
     * @return Tag
     */
    public function handle(Command $command)
    {
        $tag = $this->tags->withDescription($command->description());

        $this->dispatcher->dispatchEventsFrom(
            $this->tags->update(
                $tag
            )
        );
        return $tag;
    }
}
