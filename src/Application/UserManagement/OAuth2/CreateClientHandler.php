<?php

namespace App\Application\UserManagement\OAuth2;

use App\Application\Command;
use App\Application\CommandHandler;
use App\Domain\UserManagement\OAuth2\Client;
use App\Domain\UserManagement\OAuth2\ClientsRepository;

/**
 * CreateClientHandler
 *
 * @package App\Application\UserManagement\OAuth2
 */
final class CreateClientHandler implements CommandHandler
{
    /**
     * @var ClientsRepository
     */
    private $clientsRepository;

    /**
     * Creates a CreateClientHandler
     *
     * @param ClientsRepository $clientsRepository
     */
    public function __construct(ClientsRepository $clientsRepository)
    {
        $this->clientsRepository = $clientsRepository;
    }

    /**
     * @param CreateClientCommand|Command $command
     * @return Client
     * @throws \Exception
     */
    public function handle(Command $command): Client
    {
        $client = new Client($command->identifier(), $command->name(), $command->secret());
        return $this->clientsRepository->add($client);
    }
}

