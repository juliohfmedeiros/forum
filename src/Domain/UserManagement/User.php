<?php

namespace App\Domain\UserManagement;

use App\Domain\Comparable;
use App\Domain\UserManagement\User\Email;
use App\Domain\UserManagement\User\Password;
use App\Domain\UserManagement\User\UserId;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use League\OAuth2\Server\Entities\UserEntityInterface;

/**
 * User
 *
 * @package App\Domain\UserManagement
 *
 * @ORM\Entity()
 * @ORM\Table(name="users")
 * @IgnoreAnnotation("OA\Schema")
 * @IgnoreAnnotation("OA\Property")
 *
 * @OA\Schema(
 *     description="User",
 *     title="User"
 * )
 */

class User implements  UserEntityInterface, JsonSerializable, Comparable
{

    /**
     * @var UserId
     *
     * @ORM\Id()
     * @ORM\Column(type="UserId", name="id")
     * @ORM\GeneratedValue(strategy="NONE")
     *
     * @OA\Property(
     *     type="string",
     *     description="User identifier",
     *     example="e1026e90-9b21-4b6d-b06e-9c592f7bdb82"
     * )
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column()
     *
     * @OA\Property(
     *     description="User full name",
     *     example="John Doe"
     * )
     */
    private $name;

    /**
     * @var Email
     * @ORM\Column(type="Email")
     *
     * @OA\Property(
     *     type="string",
     *     description="User's e-mail address",
     *     example="john.doe@example.com"
     * )
     */
    private $email;

    /**
     * @var Password
     * @ORM\Column(type="Password")
     */
    private $password;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="App\Domain\QuestionManagement\Tag", mappedBy="owner")
     */
    private Collection $questions;

    /**
     * Creates an User
     *
     * @param string        $name
     * @param Email         $email
     * @param Password|null $password
     *
     * @throws \Exception
     */
    public function __construct(string $name, Email $email, Password $password = null)
    {
        $this->userId = new UserId();
        $this->name = $name;
        $this->email = $email;
        $this->password = $password ?: new Password();
        $this->questions = new ArrayCollection();
    }

    /**
     * User's internal ID
     *
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * User's full name
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * User's email address
     *
     * @return Email
     */
    public function email(): Email
    {
        return $this->email;
    }

    /**
     * User's password
     *
     * @return Password
     */
    public function password(): Password
    {
        return $this->password;
    }

    /**
     * Change user password
     *
     * @param Password $password
     *
     * @return User
     */
    public function changePassword(Password $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Updates user's name and/or e-mail address
     *
     * @param string $name
     * @param Email  $email
     *
     * @return User
     */
    public function updateInfo(string $name, Email $email): User
    {
        $this->name = $name;
        $this->email = $email;
        return $this;
    }

    /**
     * Return the user's identifier.
     *
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->userId;
    }

    /**
     * User owned questions
     *
     * @return Collection
     */
    public function questions()
    {
        return $this->questions;
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @return mixed data which can be serialized by json_encode(),
     *               which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return [
            'userId' => $this->userId,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }

    /**
     * Returns true if other object is equal to current one
     *
     * @param mixed $other
     *
     * @return bool
     */
    public function equalsTo($other): bool
    {
        if (!$other instanceof User) {
            return false;
        }

        return $this->userId()->equalsTo($other->userId());
    }

}
