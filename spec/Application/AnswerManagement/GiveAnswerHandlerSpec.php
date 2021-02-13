<?php

namespace spec\App\Application\AnswerManagement;

use App\Application\CommandHandler;
use App\Application\AnswerManagement\GiveAnswerCommand;
use App\Application\AnswerManagement\GiveAnswerHandler;
use App\Domain\AnswerManagement\Answer;
use App\Domain\AnswerManagement\AnswersRepository;
use App\Domain\UserManagement\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slick\Event\EventDispatcher;

class GiveAnswerHandlerSpec extends ObjectBehavior
{

    function let(AnswersRepository $answers, EventDispatcher $dispatcher)
    {
        /** @var Answer $newAnswer */
        $newAnswer = Argument::type(Answer::class);
        $dispatcher->dispatchEventsFrom($newAnswer)->willReturn([]);

        $answers->add($newAnswer)->willReturnArgument(0);

        $this->beConstructedWith($answers, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GiveAnswerHandler::class);
    }

    function its_a_command_handler()
    {
        $this->shouldBeAnInstanceOf(CommandHandler::class);
    }

    function it_handles_add_answer_command(User $user, AnswersRepository $answers, EventDispatcher $dispatcher)
    {
        $user->userId()->willReturn(new User\UserId());
        $command = new GiveAnswerCommand(
            $user->getWrappedObject(),
            "Tag title"
        );

        $answer = $this->handle($command);
        $answer->shouldBeAnInstanceOf(Answer::class);

        $answers->add($answer)->shouldHaveBeenCalled();
        $dispatcher->dispatchEventsFrom($answer)->shouldHaveBeenCalled();
    }
}
