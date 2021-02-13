<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\QuestionManagement;


/**
 * QuestionSpecification
 *
 * @package App\Domain\QuestionManagement
 */
interface QuestionSpecification
{

    /**
     * Returns TRUE whenever the given question is satisfied by this specification
     *
     * @param Question $question
     * @return bool
     */
    public function isSatisfiedBy(Question $question): bool;
}
