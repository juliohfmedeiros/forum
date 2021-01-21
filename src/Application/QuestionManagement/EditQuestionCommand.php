<?php

namespace App\Application\QuestionManagement;

use App\Application\Command;
use App\Domain\QuestionManagement\Question\QuestionId;

class EditQuestionCommand implements Command
{
    /**
     * @var QuestionId
     */
    private QuestionId $questionId;
    private string $title;
    private string $body;

    /**
     * Creates a EditQuestionCommand
     *
     * @param QuestionId $questionId
     * @param string $title
     * @param string $body
     */
    public function __construct(QuestionId $questionId, string $title, string $body)
    {
        $this->questionId = $questionId;
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * questionId
     *
     * @return QuestionId
     */
    public function questionId(): QuestionId
    {
        return $this->questionId;
    }

    /**
     * title
     *
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * body
     *
     * @return string
     */
    public function body(): string
    {
        return $this->body;
    }
}
