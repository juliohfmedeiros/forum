<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain;

/**
 * Comparable
 *
 * @package App\Domain
 */
interface Comparable
{

    /**
     * Returns true if other object is equal to current one
     *
     * @param mixed $other
     *
     * @return bool
     */
    public function equalsTo($other): bool;
}
