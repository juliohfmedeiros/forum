<?php

namespace spec\App\Domain\QuestionManagement\Specification;

use App\Domain\QuestionManagement\Question;
use App\Domain\QuestionManagement\QuestionSpecification;
use App\Domain\QuestionManagement\Specification\CurrentUserOwnsQuestion;
use App\Domain\UserManagement\User;
use App\Domain\UserManagement\UserIdentifier;
use PhpSpec\ObjectBehavior;

class CurrentUserOwnsQuestionSpec extends ObjectBehavior
{

    private $userId;

    function let(UserIdentifier $userIdentifier, User $currentUser)
    {
        $userIdentifier->currentUser()->willReturn($currentUser);
        $this->userId = new User\UserId();
        $currentUser->userId()->willReturn($this->userId);
        $this->beConstructedWith($userIdentifier);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CurrentUserOwnsQuestion::class);
    }

    function its_a_question_specification()
    {
        $this->shouldBeAnInstanceOf(QuestionSpecification::class);
    }

    function its_true_when_user_owns_the_question(
        User $owner,
        Question $question
    ) {
        $owner->userId()->willReturn($this->userId);
        $question->owner()->willReturn($owner);

        $this->isSatisfiedBy($question)->shouldBe(true);
    }

    function its_false_when_user_does_not_own_the_question(
        User $owner,
        Question $question
    ) {
        $owner->userId()->willReturn(new User\UserId());
        $question->owner()->willReturn($owner);

        $this->isSatisfiedBy($question)->shouldBe(false);
    }
}
