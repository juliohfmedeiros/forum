<?php

namespace spec\App\Application\UserManagement\OAuth2;

use App\Application\Command;
use App\Application\UserManagement\OAuth2\CreateClientCommand;
use PhpSpec\ObjectBehavior;

class CreateClientCommandSpec extends ObjectBehavior
{
    private $identifier;
    private $name;
    private $secret;

    function let()
    {
        $this->identifier = 'default.app';
        $this->name = 'Default application';
        $this->secret = '343ok343ok343ok';

        $this->beConstructedWith($this->identifier, $this->name, $this->secret);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CreateClientCommand::class);
    }

    function its_a_command()
    {
        $this->shouldBeAnInstanceOf(Command::class);
    }

    function it_has_an_identifier()
    {
        $this->identifier()->shouldBe($this->identifier);
    }

    function it_has_a_name()
    {
        $this->name()->shouldBe($this->name);
    }

    function it_has_a_secret()
    {
        $this->secret()->shouldBe($this->secret);
    }

    function it_can_be_created_without_a_secret()
    {
        $this->beConstructedWith($this->identifier, $this->name);
        $this->secret()->shouldBeNull();
    }

}
