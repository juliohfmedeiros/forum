<?php

namespace spec\App\Application\UserManagement\OAuth2;

use App\Application\CommandHandler;
use App\Application\UserManagement\OAuth2\CreateClientCommand;
use App\Application\UserManagement\OAuth2\CreateClientHandler;
use App\Domain\UserManagement\OAuth2\Client;
use App\Domain\UserManagement\OAuth2\ClientsRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;


class CreateClientHandlerSpec extends ObjectBehavior
{
    function let(ClientsRepository $clientsRepository)
    {
        $clientsRepository->add(Argument::type(Client::class))->willReturnArgument(0);
        $this->beConstructedWith($clientsRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CreateClientHandler::class);
    }

    function its_a_command_handler()
    {
        $this->shouldBeAnInstanceOf(CommandHandler::class);
    }

    function it_handles_a_create_client_command(ClientsRepository $clientsRepository)
    {
        $command = new CreateClientCommand('app', 'Application');
        $client = $this->handle($command);
        $client->shouldBeAnInstanceOf(Client::class);

        $clientsRepository->add($client)->shouldHaveBeenCalled();
    }

}
