<?php

namespace App\Application\QuestionManagement;

use App\Application\Command;
use App\Domain\QuestionManagement\Question\QuestionId;

/**
 * DeleteQuestionCommand
 *
 * @package App\Application\QuestionManagement
 *
 * @OA\Schema(
 *     description="DeleteQuestionCommand",
 *     title="DeleteQuestionCommand"
 * )
 */
class DeleteQuestionCommand implements Command
{
    /**
     * @var QuestionId
     */
    private QuestionId $questionId;

    /**
     * Creates a DeleteQuestionCommand
     *
     * @param QuestionId $questionId
     */
    public function __construct(QuestionId $questionId)
    {
        $this->questionId = $questionId;
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
}