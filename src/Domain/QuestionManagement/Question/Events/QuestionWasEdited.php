<?php

namespace App\Domain\QuestionManagement\Question\Events;

use App\Domain\QuestionManagement\Question\QuestionId;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

class QuestionWasEdited extends AbstractEvent implements Event
{
    /**
     * @var QuestionId
     */
    private QuestionId $questionId;
    private string $title;
    private string $body;

    /**
     * Creates a QuestionWasEdited
     *
     * @param QuestionId $questionId
     * @param string $title
     * @param string $body
     */
    public function __construct(QuestionId $questionId, string $title, string $body)
    {
        parent::__construct();
        $this->questionId = $questionId;
        $this->title = $title;
        $this->body = $body;
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

    /**
     * title
     *
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * body
     *
     * @return string
     */
    public function body(): string
    {
        return $this->body;
    }

}
