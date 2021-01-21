<?php

namespace App\Domain\QuestionManagement\Specification;

use App\Domain\QuestionManagement\Question;
use App\Domain\QuestionManagement\QuestionSpecification;
use App\Domain\UserManagement\UserIdentifier;

class CurrentUserOwnsQuestion implements QuestionSpecification
{
    /**
     * @var UserIdentifier
     */
    private UserIdentifier $userIdentifier;

    /**
     * Creates a CurrentUserOwnsQuestion
     *
     * @param UserIdentifier $userIdentifier
     */
    public function __construct(UserIdentifier $userIdentifier)
    {
        $this->userIdentifier = $userIdentifier;
    }

    /**
     * Returns TRUE whenever the given question is satisfied by this specification
     *
     * @param Question $question
     * @return bool
     */
    public function isSatisfiedBy(Question $question): bool
    {
        return $question->owner()->userId()->equalsTo(
            $this->userIdentifier->currentUser()->userId()
        );
    }
}
