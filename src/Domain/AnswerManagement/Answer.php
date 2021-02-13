<?php

namespace App\Domain\AnswerManagement;

use App\Domain\AnswerManagement\Answer\Events\AnswerWasAdded;
use App\Domain\AnswerManagement\Answer\Events\AnswerWasEdited;
use App\Domain\AnswerManagement\Answer\Events\AnswerWasDeleted;
use App\Domain\AnswerManagement\Answer\AnswerId;
use App\Domain\UserManagement\User;
use DateTimeImmutable;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Slick\Event\Domain\EventGeneratorMethods;
use Slick\Event\EventGenerator;

/**
 * Tag
 *
 * @package App\Domain\AnswerManagement
 *
 * @ORM\Entity()
 * @ORM\Table(name="answers")
 *
 * @IgnoreAnnotation("OA\Schema")
 * @IgnoreAnnotation("OA\Property")
 *
 * @OA\Schema(
 *     description="Tag",
 *     title="Tag"
 * )
 */
class Answer implements EventGenerator, JsonSerializable
{

    use EventGeneratorMethods;

    /**
     * @var AnswerId
     * @ORM\Id()
     * @ORM\Column(type="AnswerId", name="id")
     * @ORM\GeneratedValue(strategy="NONE")
     *
     * @OA\Property(
     *     type="string",
     *     description="Tag identifier",
     *     example="e1026e90-9b21-4b6d-b06e-9c592f7bdb82"
     * )
     */
    private AnswerId $answerId;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Domain\UserManagement\User", inversedBy="answers")
     * @ORM\JoinColumn(nullable=false)
     *
     * @OA\Property(
     *     description="The user that places the answer",
     *     ref="#/components/schemas/User"
     * )
     */
    private User $owner;

    /**
     * @var string
     * @ORM\Column()
     *
     * @OA\Property(
     *     description="Tag description",
     *     example="What time is it?"
     * )
     */
    private string $description;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable", name="given_on")
     *
     * @OA\Property(
     *     description="Date answer was placed",
     *     ref="#/components/schemas/DateTimeImmutable"
     * )
     */
    private DateTimeImmutable $givenOn;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     *
     * @OA\Property(
     *     description="Tag acceptance state",
     *     type="boolean",
     *     example=false
     * )
     */
    private bool $accepted = false;

    /**
     * @var DateTimeImmutable|null
     * @ORM\Column(type="datetime_immutable", name="last_edited_on", nullable=true)
     *
     * @OA\Property(
     *     description="Date answer was last edited",
     *     ref="#/components/schemas/DateTimeImmutable"
     * )
     */
    private ?DateTimeImmutable $lastEditedOn = null;


    /**
     * Creates a Tag
     *
     * @param User $owner
     * @param string $description
     */
    public function __construct(User $owner, string $description)
    {
        $this->answerId = new AnswerId();
        $this->owner = $owner;
        $this->description = $description;
        $this->givenOn = new DateTimeImmutable();
        $this->recordThat(new AnswerWasAdded($this));
    }

    /**
     * answerId
     *
     * @return AnswerId
     */
    public function answerId(): AnswerId
    {
        return $this->answerId;
    }

    /**
     * owner
     *
     * @return User
     */
    public function owner(): User
    {
        return $this->owner;
    }

    /**
     * description
     *
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }

    /**
     * givenOn
     *
     * @return DateTimeImmutable
     */
    public function givenOn(): DateTimeImmutable
    {
        return $this->givenOn;
    }

    public function lastEditedOn(): ?DateTimeImmutable
    {
        return $this->lastEditedOn;
    }

    public function accepted(): bool
    {
        return $this->accepted;
    }

    /**
     * Changes title and body of this answer
     *
     * @param string $description
     * @return Answer
     */
    public function change(string $description): Answer
    {
        $this->description = $description;
        $this->lastEditedOn = new DateTimeImmutable();
        $this->recordThat(new AnswerWasEdited(
            $this->answerId,
            $description
        ));
        return $this;
    }

    /**
     * Changes description of this answer
     *
     * @param AnswerId $answerId
     * @return Answer
     */
    public function delete(AnswerId $answerId): Answer
    {
        $this->answerId = $answerId;
        $this->recordThat(new AnswerWasDeleted(
            $this->answerId
        ));
        return $this;
    }
    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4
     */
    public function jsonSerialize()
    {
        return [
            "answerId" => $this->answerId,
            "description" => $this->description,
            "owner" => $this->owner,
            "accepted" => $this->accepted,
            "givenOn" => $this->givenOn,
            "lastEditedOn" => $this->lastEditedOn
        ];
    }
}
