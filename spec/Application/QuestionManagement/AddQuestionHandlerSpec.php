<?php

namespace spec\App\Application\QuestionManagement;

use App\Application\CommandHandler;
use App\Application\QuestionManagement\AddQuestionCommand;
use App\Application\QuestionManagement\AddQuestionHandler;
use App\Domain\QuestionManagement\Question;
use App\Domain\QuestionManagement\QuestionsRepository;
use App\Domain\UserManagement\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slick\Event\EventDispatcher;

class AddQuestionHandlerSpec extends ObjectBehavior
{

    function let(QuestionsRepository $questions, EventDispatcher $dispatcher)
    {
        /** @var Question $newQuestion */
        $newQuestion = Argument::type(Question::class);
        $dispatcher->dispatchEventsFrom($newQuestion)->willReturn([]);

        $questions->add($newQuestion)->willReturnArgument(0);

        $this->beConstructedWith($questions, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AddQuestionHandler::class);
    }

    function its_a_command_handler()
    {
        $this->shouldBeAnInstanceOf(CommandHandler::class);
    }

    function it_handles_add_question_command(User $user, QuestionsRepository $questions, EventDispatcher $dispatcher)
    {
        $user->userId()->willReturn(new User\UserId());
        $command = new AddQuestionCommand(
            $user->getWrappedObject(),
            "Question title",
            "Question body"
        );

        $question = $this->handle($command);
        $question->shouldBeAnInstanceOf(Question::class);

        $questions->add($question)->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($question)->shouldHaveBeenCalled();
    }
}
