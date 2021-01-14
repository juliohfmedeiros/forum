<?php

namespace spec\App\Domain\QuestionManagement\Question\Events;

use App\Domain\QuestionManagement\Question;
use App\Domain\QuestionManagement\Question\Events\QuestionWasCreated;
use App\Domain\UserManagement\User;
use PhpSpec\ObjectBehavior;
use Slick\Event\Domain\AbstractEvent;
use Slick\Event\Event;

class QuestionWasCreatedSpec extends ObjectBehavior
{

    private $questionId;
    private $title;
    private $body;
    private $userId;

    function let(Question $question, User $user)
    {
        $this->questionId = new Question\QuestionId();
        $this->title = "Hello?";
        $this->body = "Hi!";
        $this->userId = new User\UserId();

        $question->questionId()->willReturn($this->questionId);
        $question->title()->willReturn($this->title);
        $question->body()->willReturn($this->body);
        $question->owner()->willReturn($user);

        $user->userId()->willReturn($this->userId);


        $this->beConstructedWith($question);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(QuestionWasCreated::class);
    }

    function its_an_event()
    {
        $this->shouldBeAnInstanceOf(Event::class);
        $this->shouldHaveType(AbstractEvent::class);
        $this->occurredOn()->shouldBeAnInstanceOf(\DateTimeImmutable::class);
    }

    function it_has_a_question_id()
    {
        $this->questionId()->shouldBe($this->questionId);
    }

    function it_has_a_title()
    {
        $this->title()->shouldBe($this->title);
    }

    function it_has_a_body()
    {
        $this->body()->shouldBe($this->body);
    }

    function it_has_a_owner_id()
    {
        $this->owner()->shouldBe($this->userId);
    }
}
