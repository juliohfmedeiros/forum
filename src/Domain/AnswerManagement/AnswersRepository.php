<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\AnswerManagement;

use App\Domain\AnswerManagement\Answer;
use App\Domain\AnswerManagement\Answer\AnswerId;
use App\Domain\Exception\EntityNotFound;

/**
 * QuestionsRepository
 *
 * @package App\Domain\AnswerManagement
 */
interface AnswersRepository
{

    /**
     * Adds a question to the answer repository
     *
     * @param Answer $answer
     * @return Answer
     */
    public function add(Answer $answer): Answer;

    /**
     * Retrieves the answer stored with provided identifier
     *
     * @param AnswerId $answerId
     * @return Answer
     * @throws EntityNotFound when no answer is found for provided identifier
     */
    public function withId(AnswerId $answerId): Answer;

    /**
     * Updates changes on provided answer
     *
     * @param Answer $answer
     * @return Answer
     */
    public function update(Answer $answer): Answer;

    /**
     * Remove provided answer from repository
     *
     * @param Answer $answer
     */
    public function remove(Answer $answer): void;

}
