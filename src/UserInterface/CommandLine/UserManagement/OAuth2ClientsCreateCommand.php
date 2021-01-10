<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\UserInterface\CommandLine\UserManagement;

use App\Application\CommandBus;
use App\Application\UserManagement\OAuth2\CreateClientCommand;
use App\Domain\UserManagement\OAuth2\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * OAuth2ClientsCreateCommand
 *
 * @package App\UserInterface\CommandLine\UserManagement
 */
final class OAuth2ClientsCreateCommand extends Command
{

    private $secret;
    private $identifier;
    private $clientName;

    /**
     * @var SymfonyStyle
     */
    private $style;
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * Creates a OAuth2ClientsCreateCommand
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        parent::__construct('oauth2:clients:create');
        $this->commandBus = $commandBus;
    }

    protected function configure()
    {
        $this
            ->setHelp("Adds an OAUTH2.0 client")
            ->setDescription("Adds an OAUTH2.0 client")
            ->addArgument('identifier', InputArgument::REQUIRED, 'Client identifier')
            ->addArgument('name', InputArgument::REQUIRED, 'Client name or description')
            ->addArgument('secret', InputArgument::OPTIONAL, 'Client secret for authentication')
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);
        $this->style = new SymfonyStyle($input, $output);
        $this->clientName = $input->getArgument('name');
        $this->identifier = $input->getArgument('identifier');
        $this->secret = $input->getArgument('secret');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->style->title('Add OAuth2.0 Client');
        /** @var Client $client */
        $client = $this->commandBus->handle(
            new CreateClientCommand($this->identifier, $this->clientName, $this->secret)
        );

        $this->style->success("Client {$client->name()} successfully created with secret: {$client->secret()}");
        return 0;
    }
}
