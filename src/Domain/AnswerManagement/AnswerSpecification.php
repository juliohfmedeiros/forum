<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\AnswerManagement;

/**
 * AnswerSpecification
 *
 * @package App\Domain\AnswerManagement
 */
interface AnswerSpecification
{

    /**
     * Returns TRUE whenever the given answer is satisfied by this specification
     *
     * @param Answer $answer
     * @return bool
     */
    public function isSatisfiedBy(Answer $answer): bool;
}
