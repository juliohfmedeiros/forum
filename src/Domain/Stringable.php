<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain;

/**
 * Stringable
 *
 * @package App\Domain
 */
interface Stringable
{

    /**
     * Returns a text version of the object
     *
     * @return string
     */
    public function __toString();
}