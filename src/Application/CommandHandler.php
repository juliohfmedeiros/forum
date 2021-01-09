<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application;

/**
 * CommandHandler
 *
 * @package App\Application
 */
interface CommandHandler
{

    /**
     * Handle provide command
     *
     * @param Command $command
     * @return mixed
     */
    public function handle(Command $command);
}