<?php

namespace App\Application\AnswerManagement;

use App\Application\Command;
use App\Application\CommandHandler;
use App\Domain\AnswerManagement\Answer;
use App\Domain\AnswerManagement\AnswersRepository;
use Slick\Event\EventDispatcher;

class GiveAnswerHandler implements CommandHandler
{
    /**
     * @var AnswersRepository
     */
    private AnswersRepository $answers;
    /**
     * @var EventDispatcher
     */
    private EventDispatcher $dispatcher;

    /**
     * Creates a GiveAnswerHandler
     *
     * @param AnswersRepository $answers
     * @param EventDispatcher $dispatcher
     */
    public function __construct(AnswersRepository $answers, EventDispatcher $dispatcher)
    {
        $this->answers = $answers;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Handle provide command
     *
     * @param Command|GiveAnswerCommand $command
     * @return Answer
     */
    public function handle(Command $command)
    {
        $answer = new Answer(
            $command->owner(),
            $command->description()
        );

        $this->dispatcher->dispatchEventsFrom(
            $this->answers->add($answer)
        );

        return $answer;
    }
}
