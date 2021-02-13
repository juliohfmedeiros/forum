<?php

namespace spec\App\Application\AnswerManagement;

use App\Application\CommandHandler;
use App\Application\AnswerManagement\EditAnswerCommand;
use App\Application\AnswerManagement\EditAnswerHandler;
use App\Domain\Exception\FailedEntitySpecification;
use App\Domain\AnswerManagement\Answer;
use App\Domain\AnswerManagement\Answer\AnswerId;
use App\Domain\AnswerManagement\Specification\CurrentUserOwnsAnswer;
use App\Domain\AnswerManagement\AnswersRepository;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventDispatcher;

class EditAnswerHandlerSpec extends ObjectBehavior
{

    private $answerId;
    private $description;

    function let(
        AnswersRepository $answers,
        EventDispatcher $dispatcher,
        Answer $answer,
        CurrentUserOwnsAnswer $currentUserOwnsAnswer
    ) {

        $this->answerId = new AnswerId();
        $answers->withId($this->answerId)->willReturn($answer);

        $this->description = "Changed description";
        $answer->change($this->description)->willReturn($answer);
        $answer->accepted()->willReturn(true);

        $answers->update($answer)->willReturnArgument(0);

        $dispatcher->dispatchEventsFrom($answer)->willReturn([]);

        $this->beConstructedWith($answers, $dispatcher, $currentUserOwnsAnswer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(EditAnswerHandler::class);
    }

    function its_a_command_handler()
    {
        $this->shouldBeAnInstanceOf(CommandHandler::class);
    }

    function it_handles_edit_answer_command(
        AnswersRepository $answers,
        EventDispatcher $dispatcher,
        Answer $answer,
        CurrentUserOwnsAnswer $currentUserOwnsAnswer
    ) {
        $command = new EditAnswerCommand(
            $this->answerId,
            $this->description
        );
        $currentUserOwnsAnswer
            ->isSatisfiedBy($answer)
            ->shouldBeCalled()
            ->willReturn(true);

        $this->handle($command)->shouldBe($answer);

        $answer->change($this->description)->shouldHaveBeenCalled();
        $answers->update($answer)->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($answer)->shouldHaveBeenCalled();
    }

    function it_throws_exception_when_user_does_not_own_the_answer(
        AnswersRepository $answers,
        EventDispatcher $dispatcher,
        Answer $answer,
        CurrentUserOwnsAnswer $currentUserOwnsAnswer
    ) {
        $command = new EditAnswerCommand(
            $this->answerId,
            $this->description
        );
        $currentUserOwnsAnswer
            ->isSatisfiedBy($answer)
            ->shouldBeCalled()
            ->willReturn(false);

        $this->shouldThrow(FailedEntitySpecification::class)
            ->during('handle', [$command]);

        $answer->change($this->description)->shouldNotHaveBeenCalled();
        $answers->update($answer)->shouldNotHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($answer)->shouldNotHaveBeenCalled();
    }

    function it_throws_exception_when_answer_is_closed(
        AnswersRepository $answers,
        EventDispatcher $dispatcher,
        Answer $answer,
        CurrentUserOwnsAnswer $currentUserOwnsAnswer
    ) {
        $command = new EditAnswerCommand(
            $this->answerId,
            $this->description
        );
        $currentUserOwnsAnswer
            ->isSatisfiedBy($answer)
            ->willReturn(true);

        $answer->accepted()
            ->shouldBeCalled()
            ->willReturn(false);

        $this->shouldThrow(FailedEntitySpecification::class)
            ->during('handle', [$command]);

        $answer->change($this->description)->shouldNotHaveBeenCalled();
        $answers->update($answer)->shouldNotHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($answer)->shouldNotHaveBeenCalled();
    }
}
