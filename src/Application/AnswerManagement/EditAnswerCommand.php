<?php

namespace App\Application\AnswerManagement;

use App\Application\Command;
use App\Domain\AnswerManagement\Answer\AnswerId;

/**
 * EditAnswerCommand
 *
 * @package App\Application\AnswerManagement
 *
 * @OA\Schema(
 *     description="EditAnswerCommand",
 *     title="EditAnswerCommand"
 * )
 */
class EditAnswerCommand implements Command
{
    /**
     * @var AnswerId
     */
    private AnswerId $answerId;

    /**
     * @var string
     * @OA\Property(
     *     description="Tag title",
     *     example="What time is it in Boston?"
     * )
     *
     */
    private string $description;

    /**
     * Creates a EditAnswerCommand
     *
     * @param AnswerId $answerId
     * @param string $description
     */
    public function __construct(AnswerId $answerId, string $description)
    {
        $this->answerId = $answerId;
        $this->description = $description;
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

    /**
     * description
     *
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }

}
