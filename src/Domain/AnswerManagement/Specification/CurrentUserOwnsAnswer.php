<?php

namespace App\Domain\AnswerManagement\Specification;

use App\Domain\AnswerManagement\Answer;
use App\Domain\AnswerManagement\AnswerSpecification;
use App\Domain\UserManagement\UserIdentifier;

class CurrentUserOwnsAnswer implements AnswerSpecification
{
    /**
     * @var UserIdentifier
     */
    private UserIdentifier $userIdentifier;

    /**
     * Creates a CurrentUserOwnsAnswer
     *
     * @param UserIdentifier $userIdentifier
     */
    public function __construct(UserIdentifier $userIdentifier)
    {
        $this->userIdentifier = $userIdentifier;
    }

    /**
     * Returns TRUE whenever the given answer is satisfied by this specification
     *
     * @param Answer $answer
     * @return bool
     */
    public function isSatisfiedBy(Answer $answer): bool
    {
        return $answer->owner()->userId()->equalsTo(
            $this->userIdentifier->currentUser()->userId()
        );
    }
}
