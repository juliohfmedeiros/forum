<?php

namespace App\Domain\QuestionManagement;

use App\Domain\QuestionManagement\Question\Events\QuestionWasCreated;
use App\Domain\QuestionManagement\Question\Events\QuestionWasEdited;
use App\Domain\QuestionManagement\Question\QuestionId;
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
 * @package App\Domain\QuestionManagement
 *
 * @ORM\Entity()
 * @ORM\Table(name="questions")
 *
 * @IgnoreAnnotation("OA\Schema")
 * @IgnoreAnnotation("OA\Property")
 *
 * @OA\Schema(
 *     description="Tag",
 *     title="Tag"
 * )
 */
class Question implements EventGenerator, JsonSerializable
{

    use EventGeneratorMethods;

    /**
     * @var QuestionId
     * @ORM\Id()
     * @ORM\Column(type="QuestionId", name="id")
     * @ORM\GeneratedValue(strategy="NONE")
     *
     * @OA\Property(
     *     type="string",
     *     description="Tag identifier",
     *     example="e1026e90-9b21-4b6d-b06e-9c592f7bdb82"
     * )
     */
    private QuestionId $questionId;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Domain\UserManagement\User", inversedBy="questions")
     * @ORM\JoinColumn(nullable=false)
     *
     * @OA\Property(
     *     description="The user that places the question",
     *     ref="#/components/schemas/User"
     * )
     */
    private User $owner;

    /**
     * @var string
     * @ORM\Column()
     *
     * @OA\Property(
     *     description="Tag title",
     *     example="What time is it?"
     * )
     */
    private string $title;
    /**
     * @var string
     * @ORM\Column()
     *
     * @OA\Property(
     *     description="Tag body",
     *     example="A longuer consideration on how to ask for current time."
     * )
     */
    private string $body;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable", name="applied_on")
     *
     * @OA\Property(
     *     description="Date question was placed",
     *     ref="#/components/schemas/DateTimeImmutable"
     * )
     */
    private DateTimeImmutable $appliedOn;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     *
     * @OA\Property(
     *     description="Tag open state",
     *     type="boolean",
     *     example=false
     * )
     */
    private bool $open = true;

    /**
     * @var DateTimeImmutable|null
     * @ORM\Column(type="datetime_immutable", name="last_edited_on", nullable=true)
     *
     * @OA\Property(
     *     description="Date question was last edited",
     *     ref="#/components/schemas/DateTimeImmutable"
     * )
     */
    private ?DateTimeImmutable $lastEditedOn = null;


    /**
     * Creates a Tag
     *
     * @param User $owner
     * @param string $title
     * @param string $body
     */
    public function __construct(User $owner, string $title, string $body)
    {
        $this->questionId = new QuestionId();
        $this->owner = $owner;
        $this->title = $title;
        $this->body = $body;
        $this->appliedOn = new DateTimeImmutable();
        $this->recordThat(new QuestionWasCreated($this));
    }

    /**
     * questionId
     *
     * @return QuestionId
     */
    public function questionId(): QuestionId
    {
        return $this->questionId;
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
     * title
     *
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * body
     *
     * @return string
     */
    public function body(): string
    {
        return $this->body;
    }

    /**
     * appliedOn
     *
     * @return DateTimeImmutable
     */
    public function appliedOn(): DateTimeImmutable
    {
        return $this->appliedOn;
    }

    public function lastEditedOn(): ?DateTimeImmutable
    {
        return $this->lastEditedOn;
    }

    public function isOpen(): bool
    {
        return $this->open;
    }

    /**
     * Changes title and body of this question
     *
     * @param string $title
     * @param string $body
     * @return Question
     */
    public function change(string $title, string $body): Question
    {
        $this->title = $title;
        $this->body = $body;
        $this->lastEditedOn = new DateTimeImmutable();
        $this->recordThat(new QuestionWasEdited(
            $this->questionId,
            $title,
            $body
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
            "questionId" => $this->questionId,
            "title" => $this->title,
            "body" => $this->body,
            "owner" => $this->owner,
            "open" => $this->open,
            "appliedOn" => $this->appliedOn,
            "lastEditedOn" => $this->lastEditedOn
        ];
    }
}
