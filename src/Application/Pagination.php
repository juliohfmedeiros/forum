<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application;

use JsonSerializable;

/**
 * Pagination
 *
 * @package App\Application
 */
final class Pagination implements JsonSerializable
{

    /**
     * @var int
     */
    private $rows;

    /**
     * @var int
     */
    private $rowsPerPage;

    /**
     * @var int
     */
    private $currentPage = 1;

    /**
     * Creates a Pagination
     *
     * @param int $rows
     * @param int $rowsPerPage
     */
    public function __construct(int $rows, int $rowsPerPage = 12)
    {
        $this->rows = $rows;
        $this->rowsPerPage = $rowsPerPage;
    }

    /**
     * Dataset total rows
     *
     * @return int
     */
    public function rows(): int
    {
        return $this->rows;
    }

    /**
     * Number of rows per page
     *
     * @return int
     */
    public function rowsPerPage(): int
    {
        return $this->rowsPerPage;
    }

    public function pages()
    {
        return $this->rows % $this->rowsPerPage != 0
            ? intdiv($this->rows, $this->rowsPerPage) +1
            : $this->rows / $this->rowsPerPage;
    }

    /**
     * Current page index
     *
     * @return int
     */
    public function currentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * Sets current page index
     *
     * @param int $page
     *
     * @return Pagination
     */
    public function forPage(int $page): Pagination
    {
        $this->currentPage = $page;
        return $this;
    }

    /**
     * First result index for queries
     *
     * @return int
     */
    public function firstResult(): int
    {
        return $this->rowsPerPage * ($this->currentPage -1);
    }

    /**
     * The max results to retrieve from data source
     *
     * @return int
     */
    public function maxResults(): int
    {
        return $this->rowsPerPage;
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
            'maxResults' => $this->rowsPerPage,
            'firstResult' => $this->firstResult(),
            'rows' => $this->rows,
            'rowsPerPage' => $this->rowsPerPage,
            'currentPage' => $this->currentPage(),
            'totalPages' => $this->pages()
        ];
    }

}