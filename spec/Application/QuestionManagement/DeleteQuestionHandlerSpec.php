<?php

namespace spec\App\Application\QuestionManagement;

use App\Application\CommandHandler;
use App\Application\QuestionManagement\DeleteQuestionCommand;
use App\Application\QuestionManagement\DeleteQuestionHandler;
use App\Domain\Exception\FailedEntitySpecification;
use App\Domain\QuestionManagement\Question;
use App\Domain\QuestionManagement\Question\QuestionId;
use App\Domain\QuestionManagement\QuestionsRepository;
use App\Domain\QuestionManagement\Specification\CurrentUserOwnsQuestion;
use PhpSpec\ObjectBehavior;
use Slick\Event\EventDispatcher;

class DeleteQuestionHandlerSpec extends ObjectBehavior
{

    private $questionId;

    function let(
        QuestionsRepository $questions,
        EventDispatcher $dispatcher,
        Question $question,
        CurrentUserOwnsQuestion $currentUserOwnsQuestion
    ) {

        $this->questionId = new QuestionId();
        $questions->withId($this->questionId)->willReturn($question);

        $dispatcher->dispatchEventsFrom($question)->willReturn([]);

        $this->beConstructedWith($questions, $dispatcher, $currentUserOwnsQuestion);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(DeleteQuestionHandler::class);
    }

    function its_a_command_handler()
    {
        $this->shouldBeAnInstanceOf(CommandHandler::class);
    }

    function it_handles_delete_question_command(
        QuestionsRepository $questions,
        EventDispatcher $dispatcher,
        Question $question,
        CurrentUserOwnsQuestion $currentUserOwnsQuestion
    ) {
        $command = new DeleteQuestionCommand(
            $this->questionId
        );
        $currentUserOwnsQuestion
            ->isSatisfiedBy($question)
            ->shouldBeCalled()
            ->willReturn(true);

        $this->handle($command)->shouldBe($question);

        $questions->remove($question)->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($question)->shouldHaveBeenCalled();
    }

    function it_throws_exception_when_user_does_not_own_the_question(
        QuestionsRepository $questions,
        EventDispatcher $dispatcher,
        Question $question,
        CurrentUserOwnsQuestion $currentUserOwnsQuestion
    ) {
        $command = new DeleteQuestionCommand(
            $this->questionId
        );
        $currentUserOwnsQuestion
            ->isSatisfiedBy($question)
            ->shouldBeCalled()
            ->willReturn(false);

        $this->shouldThrow(FailedEntitySpecification::class)
            ->during('handle', [$command]);

        $questions->remove($question)->shouldNotHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($question)->shouldNotHaveBeenCalled();
    }

}
