<?php

namespace App\Domain\QuestionManagement\Question\Events;

use App\Domain\QuestionManagement\Question;
use App\Domain\UserManagement\User\UserId;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

class QuestionWasCreated extends AbstractEvent implements Event
{

    private Question\QuestionId $questionId;

    private UserId $owner;

    private string $title;

    private string $body;

    /**
     * Creates a QuestionWasCreated
     *
     * @param Question $question
     */
    public function __construct(Question $question)
    {
        parent::__construct();
        $this->questionId = $question->questionId();
        $this->title = $question->title();
        $this->body = $question->body();
        $this->owner = $question->owner()->userId();
    }

    /**
     * questionId
     *
     * @return Question\QuestionId
     */
    public function questionId(): Question\QuestionId
    {
        return $this->questionId;
    }

    /**
     * owner
     *
     * @return UserId
     */
    public function owner(): UserId
    {
        return $this->owner;
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
