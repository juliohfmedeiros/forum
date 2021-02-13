<?php

namespace App\Application\QuestionManagement;

use App\Application\Command;
use App\Domain\UserManagement\User;

/**
 * AddQuestionCommand
 *
 * @package App\Application\QuestionManagement
 *
 * @OA\Schema(
 *     description="AddQuestionCommand",
 *     title="AddQuestionCommand"
 * )
 */
class AddQuestionCommand implements Command
{
    /**
     * @var User
     */
    private User $owner;

    /**
     * @var string
     *
     * @OA\Property(
     *     description="Tag title",
     *     example="What time is it?"
     * )
     */
    private string $title;

    /**
     * @var string
     *
     * @OA\Property(
     *     description="Tag body",
     *     example="A longer consideration on how to ask for current time."
     * )
     */
    private string $body;


    /**
     * Creates a AddQuestionCommand
     *
     * @param User $owner
     * @param string $title
     * @param string $body
     */
    public function __construct(User $owner, string $title, string $body)
    {
        $this->owner = $owner;
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * owner
     *
     * @return User
     */
    public function owner(): User
    {
        return $this->owner;
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
