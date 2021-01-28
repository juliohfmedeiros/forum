<?php

namespace App\Application\QuestionManagement;

use App\Application\Command;
use App\Domain\QuestionManagement\Question\QuestionId;

/**
 * EditQuestionCommand
 *
 * @package App\Application\QuestionManagement
 *
 * @OA\Schema(
 *     description="EditQuestionCommand",
 *     title="EditQuestionCommand"
 * )
 */
class EditQuestionCommand implements Command
{
    /**
     * @var QuestionId
     */
    private QuestionId $questionId;

    /**
     * @var string
     * @OA\Property(
     *     description="Question title",
     *     example="What time is it in Boston?"
     * )
     *
     */
    private string $title;

    /**
     * @var string
     * @OA\Property(
     *     description="Question body",
     *     example="A longer consideration on how to ask for current time in Boston."
     * )
     */
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
