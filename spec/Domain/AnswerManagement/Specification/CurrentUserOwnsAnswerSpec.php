<?php

namespace spec\App\Domain\AnswerManagement\Specification;

use App\Domain\AnswerManagement\Answer;
use App\Domain\AnswerManagement\AnswerSpecification;
use App\Domain\AnswerManagement\Specification\CurrentUserOwnsAnswer;
use App\Domain\UserManagement\User;
use App\Domain\UserManagement\UserIdentifier;
use PhpSpec\ObjectBehavior;

class CurrentUserOwnsAnswerSpec extends ObjectBehavior
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
        $this->shouldHaveType(CurrentUserOwnsAnswer::class);
    }

    function its_a_answer_specification()
    {
        $this->shouldBeAnInstanceOf(AnswerSpecification::class);
    }

    function its_true_when_user_owns_the_answer(
        User $owner,
        Answer $answer
    ) {
        $owner->userId()->willReturn($this->userId);
        $answer->owner()->willReturn($owner);

        $this->isSatisfiedBy($answer)->shouldBe(true);
    }

    function its_false_when_user_does_not_own_the_answer(
        User $owner,
        Answer $answer
    ) {
        $owner->userId()->willReturn(new User\UserId());
        $answer->owner()->willReturn($owner);

        $this->isSatisfiedBy($answer)->shouldBe(false);
    }
}
