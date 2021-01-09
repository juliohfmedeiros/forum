<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\Common;

use App\Domain\Comparable;
use App\Domain\Stringable;
use JsonSerializable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * RootAggregatorId
 *
 * @package App\Domain\Common
 */
abstract class RootAggregatorId implements Stringable, JsonSerializable, Comparable
{

    /**
     * @var UuidInterface
     */
    protected $uuid;

    /**
     * Creates an ID
     *
     * @param string|null $uuidTxt
     * @throws \Exception
     */
    public function __construct(string $uuidTxt = null)
    {
        $this->uuid = $uuidTxt
            ? Uuid::fromString($uuidTxt)
            : Uuid::uuid4();
    }

    /**
     * Returns a text version of the object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->uuid;
    }

    /**
     * Converts this ID into a json string
     *
     * @return string
     */
    public function jsonSerialize()
    {
        return (string) $this->uuid;
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
        if (! is_a($other, static::class)) {
            return false;
        }

        return (bool) $other->uuid->equals($this->uuid);
    }

}

/**
 * @OA\Schema(
 *     schema="DateTime",
 *     type="object",
 *     @OA\Property(property="date", type="string", description="Formatted date", example="2018-07-04 23:07:14.000000"),
 *     @OA\Property(property="timezone_type", type="integer", format="int32", description="Timezone type ID", example="3"),
 *     @OA\Property(property="timezone", type="string", description="Timezone name", example="Atlantic/Azores")
 * )
 */
