<?php

namespace spec\App\Domain\AnswerManagement\Answer\Events;

use App\Domain\AnswerManagement\Answer;
use App\Domain\AnswerManagement\Answer\Events\AnswerWasAdded;
use App\Domain\UserManagement\User;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

class AnswerWasAddedSpec extends ObjectBehavior
{

    private $answerId;
    private $description;
    private $userId;

    function let(Answer $answer, User $user)
    {
        $this->answerId = new Answer\AnswerId();
        $this->description = "now";
        $this->userId = new User\UserId();

        $answer->answerId()->willReturn($this->answerId);
        $answer->description()->willReturn($this->description);
        $answer->owner()->willReturn($user);

        $user->userId()->willReturn($this->userId);


        $this->beConstructedWith($answer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AnswerWasAdded::class);
    }

    function its_an_event()
    {
        $this->shouldBeAnInstanceOf(Event::class);
        $this->shouldHaveType(AbstractEvent::class);
        $this->occurredOn()->shouldBeAnInstanceOf(\DateTimeImmutable::class);
    }

    function it_has_a_answer_id()
    {
        $this->answerId()->shouldBe($this->answerId);
    }

    function it_has_a_description()
    {
        $this->description()->shouldBe($this->description);
    }

    function it_has_a_owner_id()
    {
        $this->owner()->shouldBe($this->userId);
    }
}
