<?php

namespace spec\App\Domain\UserManagement\OAuth2;

use App\Domain\UserManagement\OAuth2\AccessToken;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\ObjectBehavior;
use Ramsey\Uuid\Uuid;

class AccessTokenSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AccessToken::class);
    }

    /**
     * @throws FailureException
     */
    function it_has_a_identifier()
    {
        $identifier = $this->getIdentifier();
        $identifier->shouldBeString();
        if (!Uuid::isValid($identifier->getWrappedObject())) {
            throw new FailureException(
                "Expected an UUID string, but it was invalid..."
            );
        }
    }

    function its_an_oauth2_access_token()
    {
        $this->shouldBeAnInstanceOf(AccessTokenEntityInterface::class);
    }

}
