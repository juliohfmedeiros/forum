<?php

namespace App\Domain\QuestionManagement;

use App\Domain\QuestionManagement\Question\Events\QuestionWasCreated;
use App\Domain\QuestionManagement\Question\Events\QuestionWasEdited;
use App\Domain\QuestionManagement\Question\QuestionId;
use App\Domain\UserManagement\User;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Slick\Event\Domain\EventGeneratorMethods;
use Slick\Event\EventGenerator;

/**
 * Question
 *
 * @package App\Domain\QuestionManagement
 *
 * @ORM\Entity()
 * @ORM\Table(name="questions")
 */
class Question implements EventGenerator
{

    use EventGeneratorMethods;

    /**
     * @var QuestionId
     * @ORM\Id()
     * @ORM\Column(type="QuestionId", name="id")
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private QuestionId $questionId;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Domain\UserManagement\User", inversedBy="questions")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $owner;

    /**
     * @var string
     * @ORM\Column()
     */
    private string $title;
    /**
     * @var string
     * @ORM\Column()
     */
    private string $body;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable", name="applied_on")
     */
    private DateTimeImmutable $appliedOn;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private bool $open = true;

    /**
     * @var DateTimeImmutable|null
     * @ORM\Column(type="datetime_immutable", name="last_edited_on", nullable=true)
     */
    private ?DateTimeImmutable $lastEditedOn = null;


    /**
     * Creates a Question
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
}
