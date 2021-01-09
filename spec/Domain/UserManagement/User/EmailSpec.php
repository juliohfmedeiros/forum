<?php

namespace spec\App\Domain\UserManagement\User;

use App\Domain\Comparable;
use App\Domain\Exception\InvalidEmailAddress;
use App\Domain\UserManagement\User\Email;
use JsonSerializable;
use PhpSpec\ObjectBehavior;
use Stringable;

class EmailSpec extends ObjectBehavior
{
    private $email;

    function let()
    {
        $this->email = 'filipe.silva@sata.pt';
        $this->beConstructedWith($this->email);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Email::class);
    }

    function it_can_be_converted_to_string()
    {
        $this->shouldBeAnInstanceOf(Stringable::class);
        $this->__toString()->shouldBe($this->email);
    }

    function it_can_be_converted_to_json()
    {
        $this->shouldBeAnInstanceOf(JsonSerializable::class);
        $this->jsonSerialize()->shouldBe($this->email);
    }

    function it_can_be_compared()
    {
        $this->shouldBeAnInstanceOf(Comparable::class);
        $this->equalsTo(new Email($this->email))->shouldBe(true);
    }

    function it_throws_invalid_argument_exception_for_invalid_email_addresses()
    {
        $this->beConstructedWith('test');
        $this->shouldThrow(InvalidEmailAddress::class)
            ->duringInstantiation();
    }

}
