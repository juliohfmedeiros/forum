<?php

namespace App\Application\AnswerManagement;

use App\Application\Command;
use App\Domain\UserManagement\User;

/**
 * GiveAnswerCommand
 *
 * @package App\Application\AnswerManagement
 *
 * @OA\Schema(
 *     description="GiveAnswerCommand",
 *     title="GiveAnswerCommand"
 * )
 */
class GiveAnswerCommand implements Command
{
    /**
     * @var User
     */
    private User $owner;

    /**
     * @var string
     *
     * @OA\Property(
     *     description="Tag body",
     *     example="What time is it?"
     * )
     */
    private string $description;

    /**
     * Creates a GiveAnswerCommand
     *
     * @param User $owner
     * @param string $description
     */
    public function __construct(User $owner, string $description)
    {
        $this->owner = $owner;
        $this->description = $description;
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
     * description
     *
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }

}
