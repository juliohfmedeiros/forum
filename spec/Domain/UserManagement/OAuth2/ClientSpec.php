<?php

namespace spec\App\Domain\UserManagement\OAuth2;

use App\Domain\UserManagement\OAuth2\Client;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use PhpSpec\ObjectBehavior;

class ClientSpec extends ObjectBehavior
{
    private $identifier;
    private $name;
    private $secret;
    private $redirectUri;

    function let()
    {
        $this->identifier = 'default-app';
        $this->name = 'Default app';
        $this->secret = '23223';
        $this->redirectUri = 'http://example.com/auth';
        $this->beConstructedWith($this->identifier, $this->name, $this->secret, $this->redirectUri);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Client::class);
    }

    function it_has_am_identifier()
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

    function it_has_a_redirect_uri()
    {
        $this->redirectUri()->shouldBe($this->redirectUri);
    }

    function it_can_be_created_without_secret_and_uri()
    {
        $this->beConstructedWith($this->identifier, $this->name);
        $this->redirectUri()->shouldBe([]);
        $this->secret()->shouldBeString();
    }

    function its_an_oauth2_client_entity()
    {
        $this->shouldBeAnInstanceOf(ClientEntityInterface::class);
        $this->getIdentifier()->shouldBe($this->identifier);
        $this->getName()->shouldBe($this->name);
        $this->getRedirectUri($this->redirectUri);
    }

}
