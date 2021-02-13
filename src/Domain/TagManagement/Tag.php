<?php

namespace App\Domain\TagManagement;

use App\Domain\TagManagement\Tag\Events\TagWasAdded;
use Slick\Event\Domain\EventGeneratorMethods;
use Slick\Event\EventGenerator;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * Tag
 *
 * @package App\Domain\TagManagement
 *
 * @ORM\Entity()
 * @ORM\Table(name="tags")
 *
 * @IgnoreAnnotation("OA\Schema")
 * @IgnoreAnnotation("OA\Property")
 *
 * @OA\Schema(
 *     description="Tag",
 *     title="Tag"
 * )
 */
class Tag implements EventGenerator, JsonSerializable
{

    use EventGeneratorMethods;

    /**
     * @var string
     * @ORM\Column()
     *
     * @OA\Property(
     *     description="Tag description",
     *     example="time"
     * )
     */
    private string $description;

    /**
     * Creates a Tag
     *
     * @param string $description
     */
    public function __construct(string $description)
    {
        $this->description = $description;
        $this->recordThat(new TagWasAdded($this));
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
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4
     */
    public function jsonSerialize()
    {
        return [
            "description" => $this->description
        ];
    }
}
