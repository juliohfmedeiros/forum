<?php

namespace spec\App\Application\AnswerManagement;

use App\Application\CommandHandler;
use App\Application\AnswerManagement\DeleteAnswerCommand;
use App\Application\AnswerManagement\DeleteAnswerHandler;
use App\Domain\Exception\FailedEntitySpecification;
use App\Domain\AnswerManagement\Answer;
use App\Domain\AnswerManagement\Answer\AnswerId;
use App\Domain\AnswerManagement\Specification\CurrentUserOwnsAnswer;
use App\Domain\AnswerManagement\AnswersRepository;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventDispatcher;

class DeleteAnswerHandlerSpec extends ObjectBehavior
{

    private $answerId;

    function let(
        AnswersRepository $answers,
        EventDispatcher $dispatcher,
        Answer $answer,
        CurrentUserOwnsAnswer $currentUserOwnsAnswer
    ) {

        $this->answerId = new AnswerId();
        $answers->withId($this->answerId)->willReturn($answer);

        $dispatcher->dispatchEventsFrom($answer)->willReturn([]);

        $this->beConstructedWith($answers, $dispatcher, $currentUserOwnsAnswer);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(DeleteAnswerHandler::class);
    }

    function its_a_command_handler()
    {
        $this->shouldBeAnInstanceOf(CommandHandler::class);
    }

    function it_handles_delete_answer_command(
        AnswersRepository $answers,
        EventDispatcher $dispatcher,
        Answer $answer,
        CurrentUserOwnsAnswer $currentUserOwnsAnswer
    ) {
        $command = new DeleteAnswerCommand(
            $this->answerId
        );
        $currentUserOwnsAnswer
            ->isSatisfiedBy($answer)
            ->shouldBeCalled()
            ->willReturn(true);

        $this->handle($command)->shouldBe($answer);

        $answers->remove($answer)->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($answer)->shouldHaveBeenCalled();
    }

    function it_throws_exception_when_user_does_not_own_the_answer(
        AnswersRepository $answers,
        EventDispatcher $dispatcher,
        Answer $answer,
        CurrentUserOwnsAnswer $currentUserOwnsAnswer
    ) {
        $command = new DeleteAnswerCommand(
            $this->answerId,
        );
        $currentUserOwnsAnswer
            ->isSatisfiedBy($answer)
            ->shouldBeCalled()
            ->willReturn(false);

        $this->shouldThrow(FailedEntitySpecification::class)
            ->during('handle', [$command]);

        $answers->remove($answer)->shouldNotHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($answer)->shouldNotHaveBeenCalled();
    }

}
