<?php

namespace spec\App\Domain\AnswerManagement;

use App\Domain\AnswerManagement\Answer;
use App\Domain\AnswerManagement\Answer\Events\AnswerWasEdited;
use App\Domain\QuestionManagement\Question;
use App\Domain\QuestionManagement\QuestionsRepository;
use App\Domain\UserManagement\User;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventGenerator;

class AnswerSpec extends ObjectBehavior
{
    private $description;

    function let(User $user)
    {
        $user->userId()->willReturn(new User\UserId());
        $this->description = "now";
        $this->beConstructedWith($user, $this->description);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Answer::class);
    }

    function its_an_event_generator()
    {
        $this->shouldBeAnInstanceOf(EventGenerator::class);
        $this->releaseEvents()[0]->shouldBeAnInstanceOf(Answer\Events\AnswerWasAdded::class);
    }

    function it_has_a_answer_id()
    {
        $this->answerId()->shouldBeAnInstanceOf(Answer\AnswerId::class);
    }

    function it_has_a_user(User $user)
    {
        $this->owner()->shouldBe($user);
    }

    function it_has_a_description()
    {
        $this->description()->shouldBe($this->description);
    }

    function it_has_a_date_when_it_was_givenOn()
    {
        $this->givenOn()->shouldBeAnInstanceOf(\DateTimeImmutable::class);
    }

    function it_has_a_last_edited_on_date_time()
    {
        $this->lastEditedOn()->shouldBe(null);
    }

    function it_has_a_accepted_status()
    {
        $this->accepted()->shouldBe(false);
    }

    function it_can_be_changed()
    {
        $description = "new now";

        $this->releaseEvents();
        $this->change($description)->shouldBe($this->getWrappedObject());

        $this->description()->shouldBe($description);
        $this->lastEditedOn()->shouldBeAnInstanceOf(\DateTimeImmutable::class);
        $this->releaseEvents()[0]->shouldBeAnInstanceOf(AnswerWasEdited::class);
    }

    function it_can_be_converted_to_json(User $user)
    {
        $this->shouldBeAnInstanceOf(\JsonSerializable::class);
        $this->jsonSerialize()->shouldBe([
            "answerId" => $this->answerId()->getWrappedObject(),
            "description" => $this->description,
            "owner" => $user,
            "accepted" => false,
            "givenOn" => $this->givenOn()->getWrappedObject(),
            "lastEditedOn" => null,
        ]);
    }
}
