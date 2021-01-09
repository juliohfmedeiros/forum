<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\CommandBus;

use League\Tactician\Exception\MissingHandlerException;
use League\Tactician\Handler\Locator\HandlerLocator;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * ClassNameHandlerLocator
 *
 * @package App\Infrastructure\CommandBus
 */
final class ClassNameHandlerLocator implements HandlerLocator
{
    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    /**
     * Creates a CommandHandlerLocator
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    /**
     * Retrieves the handler for a specified command
     *
     * @param string $commandName
     *
     * @return object
     *
     * @throws MissingHandlerException
     */
    public function getHandlerForCommand($commandName)
    {
        try {
            return $this->container->get(
                $this->getClassName($commandName)
            );
        } catch (NotFoundExceptionInterface $exception) {
            throw MissingHandlerException::forCommand($commandName);
        }
    }

    /**
     * Gets the handler classname
     *
     * @param string $commandClassName
     * @return string
     */
    private function getClassName(string $commandClassName): string
    {
        $parts = explode('\\', $commandClassName);
        $last = array_pop($parts);
        $last = str_replace('Command', 'Handler', $last);
        array_push($parts, $last);
        return implode('\\', $parts);
    }
}
