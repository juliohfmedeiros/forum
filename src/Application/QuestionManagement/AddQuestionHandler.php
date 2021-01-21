<?php

namespace App\Application\QuestionManagement;

use App\Application\Command;
use App\Application\CommandHandler;
use App\Domain\QuestionManagement\Question;
use App\Domain\QuestionManagement\QuestionsRepository;
use Slick\Event\EventDispatcher;

class AddQuestionHandler implements CommandHandler
{
    /**
     * @var QuestionsRepository
     */
    private QuestionsRepository $questions;
    /**
     * @var EventDispatcher
     */
    private EventDispatcher $dispatcher;

    /**
     * Creates a AddQuestionHandler
     *
     * @param QuestionsRepository $questions
     * @param EventDispatcher $dispatcher
     */
    public function __construct(QuestionsRepository $questions, EventDispatcher $dispatcher)
    {
        $this->questions = $questions;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Handle provide command
     *
     * @param Command|AddQuestionCommand $command
     * @return Question
     */
    public function handle(Command $command)
    {
        $question = new Question(
            $command->owner(),
            $command->title(),
            $command->body()
        );

        $this->dispatcher->dispatchEventsFrom(
            $this->questions->add($question)
        );

        return $question;
    }
}
