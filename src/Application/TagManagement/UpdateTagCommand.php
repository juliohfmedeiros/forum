<?php

namespace App\Application\TagManagement;

use App\Application\Command;

/**
 * UpdateTagCommand
 *
 * @package App\Application\TagManagement
 *
 * @OA\Schema(
 *     description="UpdateTagCommand",
 *     title="UpdateTagCommand"
 * )
 */
class UpdateTagCommand implements Command
{

    /**
     * @var string
     * @OA\Property(
     *     description="Tag title",
     *     example="time"
     * )
     *
     */
    private string $description;

    /**
     * Creates a UpdateTagCommand
     *
     * @param string $description
     */
    public function __construct(string $description)
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
