<?php

namespace spec\App\Domain\UserManagement;

use App\Domain\Comparable;
use App\Domain\UserManagement\User;
use League\OAuth2\Server\Entities\UserEntityInterface;
use PhpSpec\ObjectBehavior;

class UserSpec extends ObjectBehavior
{
    private $strPass;
    private $password;
    private $email;
    private $name;

    function let()
    {
        $this->strPass = '2345';
        $this->password = new User\Password($this->strPass);
        $this->email = new User\Email('john.doe@example.com');
        $this->name = 'John Doe';

        $this->beConstructedWith($this->name, $this->email, $this->password);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(User::class);
    }

    function it_has_a_user_id()
    {
        $this->userId()->shouldBeAnInstanceOf(User\UserId::class);
    }

    function it_has_a_name()
    {
        $this->name()->shouldBe($this->name);
    }

    function it_has_an_email()
    {
        $this->email()->shouldBe($this->email);
    }

    function it_has_a_password()
    {
        $this->password()->shouldBe($this->password);
    }

    function it_can_change_its_password()
    {
        $password = new User\Password('8u88u');
        $this->changePassword($password)->shouldBe($this->getWrappedObject());
        $this->password()->shouldBe($password);
    }

    function it_can_update_its_info()
    {
        $name = 'Jane Doe';
        $email = new User\Email('jane.doe@example.com');

        $this->updateInfo($name, $email)->shouldBe($this->getWrappedObject());

        $this->name()->shouldBe($name);
        $this->email()->shouldBe($email);
    }

    function its_a_oauth2_user_entity()
    {
        $this->shouldImplement(UserEntityInterface::class);
        $this->getIdentifier()->shouldBeAnInstanceOf(User\UserId::class);
    }

    function it_can_be_converted_to_json()
    {
        $this->shouldBeAnInstanceOf(\JsonSerializable::class);
        $this->jsonSerialize()->shouldBe([
            'userId' => $this->userId(),
            'name' => $this->name,
            'email' => $this->email,
        ]);
    }

    function it_can_be_compared_to_other_user(User $other)
    {
        $other->userId()->willReturn($this->userId()->getWrappedObject());
        $this->shouldBeAnInstanceOf(Comparable::class);
        $this->equalsTo($other)->shouldBe(true);
    }
}
