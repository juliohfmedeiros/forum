<?php

namespace App\Application\AnswerManagement;

use App\Application\Command;
use App\Domain\AnswerManagement\Answer\AnswerId;

/**
 * DeleteAnswerCommand
 *
 * @package App\Application\AnswerManagement
 *
 * @OA\Schema(
 *     description="DeleteAnswerCommand",
 *     title="DeleteAnswerCommand"
 * )
 */
class DeleteAnswerCommand implements Command
{
    /**
     * @var AnswerId
     */
    private AnswerId $answerId;

    /**
     * Creates a DeleteAnswerCommand
     *
     * @param AnswerId $answerId
     */
    public function __construct(AnswerId $answerId)
    {
        $this->answerId = $answerId;
    }

    /**
     * answerId
     *
     * @return AnswerId
     */
    public function answerId(): AnswerId
    {
        return $this->answerId;
    }
}