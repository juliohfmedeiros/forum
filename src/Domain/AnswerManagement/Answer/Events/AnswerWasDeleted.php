<?php

namespace App\Domain\AnswerManagement\Answer\Events;

use App\Domain\AnswerManagement\Answer\AnswerId;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

class AnswerWasDeleted extends AbstractEvent implements Event
{
    /**
     * @var AnswerId
     */
    private AnswerId $answerId;

    /**
     * Creates a AnswerWasDeleted
     *
     * @param AnswerId $answerId
     */
    public function __construct(AnswerId $answerId)
    {
        parent::__construct();
        $this->answerId = $answerId;
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
}
