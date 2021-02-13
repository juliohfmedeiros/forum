<?php

namespace App\Domain\TagManagement\Tag\Events;

use App\Domain\TagManagement\Tag;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

class TagWasAdded extends AbstractEvent implements Event
{

    private string $description;

    /**
     * Creates a TagWasAdded
     *
     * @param Tag $tag
     */
    public function __construct(Tag $tag)
    {
        parent::__construct();
        $this->description = $tag->description();
    }

    /**
     * tag
     *
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }
}
