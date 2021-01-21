<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\QuestionManagement;

use App\Domain\Exception\EntityNotFound;
use App\Domain\QuestionManagement\Question\QuestionId;

/**
 * QuestionsRepository
 *
 * @package App\Domain\QuestionManagement
 */
interface QuestionsRepository
{

    /**
     * Adds a question to the questions repository
     *
     * @param Question $question
     * @return Question
     */
    public function add(Question $question): Question;

    /**
     * Retrieves the question stored with provided identifier
     *
     * @param QuestionId $questionId
     * @return Question
     * @throws EntityNotFound when no question is found for provided identifier
     */
    public function withId(QuestionId $questionId): Question;
}
