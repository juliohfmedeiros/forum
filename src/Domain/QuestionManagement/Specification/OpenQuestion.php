<?php

namespace App\Domain\QuestionManagement\Specification;

use App\Domain\QuestionManagement\Question;
use App\Domain\QuestionManagement\QuestionSpecification;

class OpenQuestion implements QuestionSpecification
{

    /**
     * Creates an open question specification instance
     *
     * @return OpenQuestion
     */
    public static function create(): OpenQuestion
    {
        return new OpenQuestion();
    }

    /**
     * Returns TRUE whenever the given question is satisfied by this specification
     *
     * @param Question $question
     * @return bool
     */
    public function isSatisfiedBy(Question $question): bool
    {
        return $question->isOpen();
    }
}
