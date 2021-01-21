<?php

namespace App\Domain\QuestionManagement\Question\Events;

use App\Domain\QuestionManagement\Question\QuestionId;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

class QuestionWasDeleted extends AbstractEvent implements Event
{
    /**
     * @var QuestionId
     */
    private QuestionId $questionId;

    /**
     * Creates a QuestionWasDeleted
     *
     * @param QuestionId $questionId
     */
    public function __construct(QuestionId $questionId)
    {
        parent::__construct();
        $this->questionId = $questionId;
    }

    /**
     * questionId
     *
     * @return QuestionId
     */
    public function questionId(): QuestionId
    {
        return $this->questionId;
    }
}
