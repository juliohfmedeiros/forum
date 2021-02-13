<?php

namespace App\Application\AnswerManagement;

use App\Application\Command;
use App\Application\CommandHandler;
use App\Domain\Exception\FailedEntitySpecification;
use App\Domain\AnswerManagement\Answer;
use App\Domain\AnswerManagement\Specification\CurrentUserOwnsAnswer;
use App\Domain\AnswerManagement\AnswersRepository;
use Slick\Event\EventDispatcher;

class DeleteAnswerHandler implements CommandHandler
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
     * @var CurrentUserOwnsAnswer
     */
    private CurrentUserOwnsAnswer $currentUserOwnsAnswer;

    /**
     * Creates a DeleteAnswerHandler
     *
     * @param AnswersRepository $answers
     * @param EventDispatcher $dispatcher
     * @param CurrentUserOwnsAnswer $currentUserOwnsAnswer
     */
    public function __construct(
        AnswersRepository $answers,
        EventDispatcher $dispatcher,
        CurrentUserOwnsAnswer $currentUserOwnsAnswer
    ) {
        $this->answers = $answers;
        $this->dispatcher = $dispatcher;
        $this->currentUserOwnsAnswer = $currentUserOwnsAnswer;
    }

    /**
     * Handle provide command
     *
     * @param Command|DeleteAnswerCommand $command
     * @return Answer
     */
    public function handle(Command $command): Answer
    {
        $answer = $this->answers->withId($command->answerId());
        if (!$this->currentUserOwnsAnswer->isSatisfiedBy($answer)) {
            throw new FailedEntitySpecification(
                "Only answer owner can delete the answer."
            );
        }

        $this->answers->remove($answer);
        $this->dispatcher->dispatchEventsFrom($answer);
        return $answer;
    }
}