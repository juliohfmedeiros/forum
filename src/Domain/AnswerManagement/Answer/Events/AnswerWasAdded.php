<?php

namespace App\Domain\AnswerManagement\Answer\Events;

use App\Domain\AnswerManagement\Answer;
use App\Domain\UserManagement\User\UserId;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

class AnswerWasAdded extends AbstractEvent implements Event
{

    private Answer\AnswerId $answerId;

    private UserId $owner;

    private string $description;

    /**
     * Creates a AnswerWasAdded
     *
     * @param Answer $answer
     */
    public function __construct(Answer $answer)
    {
        parent::__construct();
        $this->answerId = $answer->answerId();
        $this->description = $answer->description();
        $this->owner = $answer->owner()->userId();
    }

    /**
     * answerId
     *
     * @return Answer\AnswerId
     */
    public function answerId(): Answer\AnswerId
    {
        return $this->answerId;
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
     * description
     *
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }
}
