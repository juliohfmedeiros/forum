<?php

namespace App\Domain\AnswerManagement\Answer\Events;

use App\Domain\AnswerManagement\Answer\AnswerId;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

class AnswerWasEdited extends AbstractEvent implements Event
{
    /**
     * @var AnswerId
     */
    private AnswerId $answerId;
    private string $description;

    /**
     * Creates a AnswerWasEdited
     *
     * @param AnswerId $answerId
     * @param string $description
     */
    public function __construct(AnswerId $answerId, string $description)
    {
        parent::__construct();
        $this->answerId = $answerId;
        $this->description = $description;
    }

    /**
     * answerId
     *
     * @return AnswerId
     */
    public function answerId(): AnswerId
    {
        return $this->answerId;
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
