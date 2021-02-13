<?php

namespace App\Domain\TagManagement\Tag\Events;

use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

class TagWasRemoved extends AbstractEvent implements Event
{
    /**
     * @var string
     */
    private string $description;

    /**
     * Creates a TagWasRemoved
     *
     * @param string $description
     */
    public function __construct(string $description)
    {
        parent::__construct();
        $this->description = $description;
    }

    /**
     * description
     *
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }
}
