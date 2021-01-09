<?php

namespace spec\App\Domain\UserManagement\OAuth2;

use App\Domain\UserManagement\OAuth2\Scope;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use PhpSpec\ObjectBehavior;

class ScopeSpec extends ObjectBehavior
{
    private $description;
    private $identifier;

    function let()
    {
        $this->description = 'Default scope';
        $this->identifier = 'use.app';
        $this->beConstructedWith($this->identifier, $this->description);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Scope::class);
    }

    function it_has_an_identifier()
    {
        $this->identifier()->shouldBe($this->identifier);
    }

    function it_has_a_description()
    {
        $this->description()->shouldBe($this->description);
    }
    function its_an_oauth2_scope()
    {
        $this->shouldBeAnInstanceOf(ScopeEntityInterface::class);
        $this->getIdentifier()->shouldBe($this->identifier);
    }

}
