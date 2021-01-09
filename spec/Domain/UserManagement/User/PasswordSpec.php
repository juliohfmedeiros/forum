<?php

namespace spec\App\Domain\UserManagement\User;

use App\Domain\Stringable;
use App\Domain\UserManagement\User\Password;
use PhpSpec\ObjectBehavior;

class PasswordSpec extends ObjectBehavior
{
    private $passwordStr;

    function let()
    {
        $this->passwordStr = '12345';
        $this->beConstructedWith($this->passwordStr);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Password::class);
    }

    function it_can_match_against_a_text_password()
    {
        $this->match($this->passwordStr)->shouldBe(true);
    }

    function it_can_be_created_from_an_hash()
    {
        $password = 'some-secret';
        $hash = password_hash($password, PASSWORD_ARGON2I);
        $this->beConstructedThrough('fromHash', [$hash]);
        $this->match($password)->shouldBe(true);
    }

    function it_can_be_converted_to_string()
    {
        $this->shouldBeAnInstanceOf(Stringable::class);
        $this->__toString()->shouldMatch('/\$argon2i\$.*/i');
    }

}
