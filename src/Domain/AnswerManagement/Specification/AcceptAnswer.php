<?php

namespace App\Domain\AnswerManagement\Specification;

use App\Domain\AnswerManagement\Answer;
use App\Domain\AnswerManagement\AnswerSpecification;

class AcceptAnswer implements AnswerSpecification
{

    /**
     * Creates an open answer specification instance
     *
     * @return AcceptAnswer
     */
    public static function create(): AcceptAnswer
    {
        return new AcceptAnswer();
    }

    /**
     * Returns TRUE whenever the given answer is satisfied by this specification
     *
     * @param Answer $answer
     * @return bool
     */
    public function isSatisfiedBy(Answer $answer): bool
    {
        return $answer->accepted();
    }
}
