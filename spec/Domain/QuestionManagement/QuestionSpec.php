<?php

namespace spec\App\Domain\QuestionManagement;

use App\Domain\QuestionManagement\Question;
use App\Domain\QuestionManagement\Question\Events\QuestionWasEdited;
use App\Domain\UserManagement\User;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventGenerator;

class QuestionSpec extends ObjectBehavior
{

    private $title;
    private $body;

    function let(User $user)
    {
        $user->userId()->willReturn(new User\UserId());
        $this->title = "What time is it?";
        $this->body = "I can't see...";
        $this->beConstructedWith($user, $this->title, $this->body);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Question::class);
    }

    function its_an_event_generator()
    {
        $this->shouldBeAnInstanceOf(EventGenerator::class);
        $this->releaseEvents()[0]->shouldBeAnInstanceOf(Question\Events\QuestionWasCreated::class);
    }

    function it_has_a_question_id()
    {
        $this->questionId()->shouldBeAnInstanceOf(Question\QuestionId::class);
    }

    function it_has_a_user(User $user)
    {
        $this->owner()->shouldBe($user);
    }

    function it_has_a_title()
    {
        $this->title()->shouldBe($this->title);
    }

    function it_has_a_body()
    {
        $this->body()->shouldBe($this->body);
    }

    function it_has_a_date_when_it_was_applied()
    {
        $this->appliedOn()->shouldBeAnInstanceOf(\DateTimeImmutable::class);
    }

    function it_has_a_last_edited_on_date_time()
    {
        $this->lastEditedOn()->shouldBe(null);
    }

    function it_has_a_open_status()
    {
        $this->isOpen()->shouldBe(true);
    }

    function it_can_be_changed()
    {
        $title = "new title";
        $body = "new body";

        $this->releaseEvents();
        $this->change($title, $body)->shouldBe($this->getWrappedObject());

        $this->title()->shouldBe($title);
        $this->body()->shouldBe($body);
        $this->lastEditedOn()->shouldBeAnInstanceOf(\DateTimeImmutable::class);
        $this->releaseEvents()[0]->shouldBeAnInstanceOf(QuestionWasEdited::class);
    }

    function it_can_be_converted_to_json(User $user)
    {
        $this->shouldBeAnInstanceOf(\JsonSerializable::class);
        $this->jsonSerialize()->shouldBe([
            "questionId" => $this->questionId()->getWrappedObject(),
            "title" => $this->title,
            "body" => $this->body,
            "owner" => $user,
            "open" => true,
            "appliedOn" => $this->appliedOn()->getWrappedObject(),
            "lastEditedOn" => null,
        ]);
    }
}
