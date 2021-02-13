<?php

namespace App\Application\TagManagement;

use App\Application\Command;

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
class AddTagCommand implements Command
{

    /**
     * @var string
     *
     * @OA\Property(
     *     description="tag description",
     *     example="time"
     * )
     */
    private string $description;

    /**
     * Creates a AddTagCommand
     *
     * @param string $description
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
