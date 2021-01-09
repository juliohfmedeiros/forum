<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\CommandBus;

use App\Application\Command;
use App\Application\CommandBus;
use League\Tactician\CommandBus as LeagueCommandBus;

/**
 * TacticianCommandBus
 *
 * @package App\Infrastructure\CommandBus
 */
final class TacticianCommandBus implements CommandBus
{
    /**
     * @var LeagueCommandBus
     */
    private LeagueCommandBus $commandBus;

    /**
     * Creates a TacticianCommandBus
     *
     * @param LeagueCommandBus $commandMiddleware
     */
    public function __construct(LeagueCommandBus $commandMiddleware)
    {
        $this->commandBus = $commandMiddleware;
    }

    /**
     * @inheritDoc
     */
    public function handle(Command $command)
    {
        return $this->commandBus->handle($command);
    }
}
