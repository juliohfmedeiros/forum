<?php

namespace App\Application\TagManagement;

use App\Application\Command;

class RemoveTagCommand implements Command
{
    /**
     * @var string
     *
     * @OA\Property(
     *     description="Tag description",
     *     example="time"
     * )
     */
    private string $description;

    /**
     * AddTagCommand
     *
     * @package App\Application\TagManagement
     *
     * @OA\Schema(
     *     description="AddTagCommand",
     *     title="AddTagCommand"
     * )
     */
    public function __construct($description)
    {
        $this->description = $description;
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
