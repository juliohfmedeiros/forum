<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use Traversable;


/**
 * QueryResult
 *
 * @package App\Application
 */
final class QueryResult implements IteratorAggregate, Countable, JsonSerializable
{

    /**
     * @var array
     */
    private $attributes = [];

    /**
     * @var array
     */
    private $data;

    /**
     * @var int
     */
    private $count = 0;

    /**
     * Creates a QueryResult
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->updateData($data);
    }

    /**
     * List of query attributes
     *
     * @return array
     */
    public function attributes(): array
    {
        return $this->attributes;
    }

    /**
     * Ads an attribute
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return QueryResult
     */
    public function addAttribute(string $name, $value): QueryResult
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    /**
     * Returns current attributes list
     *
     * @param string $name
     * @param null   $default
     *
     * @return mixed|null
     */
    public function attribute(string $name, $default = null)
    {
        if (array_key_exists($name, $this->attributes)) {
            $default = $this->attributes[$name];
        }

        return $default;
    }

    /**
     * Removes an attribute
     *
     * @param string $name
     *
     * @return QueryResult
     */
    public function removeAttribute(string $name): QueryResult
    {
        if (array_key_exists($name, $this->attributes)) {
            unset($this->attributes[$name]);
        }

        return $this;
    }

    /**
     * Retrieve an external iterator
     *
     * @return Traversable|ArrayIterator An instance of an object implementing
     *                                   Iterator or Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }

    /**
     * Count elements of an object
     *
     * @return int The custom count as an integer.
     * The return value is cast to an integer.
     */
    public function count()
    {
        return $this->count;
    }

    /**
     * Updates current dataset
     *
     * @param array $data
     *
     * @return QueryResult
     */
    public function updateData(array $data): QueryResult
    {
        $this->data = $data;
        $this->count = count($data);
        return $this;
    }

    /**
     * Check if current dataset is empty
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->data);
    }

    /**
     * True if this query result is using pagination
     *
     * @return bool
     */
    public function isPaginated(): bool
    {
        return (bool) $this->attribute('pagination', false);
    }

    /**
     * Make this result paginated with provided pagination object
     *
     * @param Pagination $pagination
     *
     * @return QueryResult
     */
    public function withPagination(Pagination $pagination): QueryResult
    {
        return $this->addAttribute('pagination', $pagination);
    }

    /**
     * Pagination object
     *
     * @return Pagination|null
     */
    public function pagination(): ?Pagination
    {
        $pagination = $this->attribute('pagination');

        return $pagination instanceof Pagination ? $pagination : null;
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *               which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return [
            'attributes' => $this->attributes,
            'data' => $this->data,
            'count' => $this->count,
            'isEmpty' => $this->isEmpty()
        ];
    }

}