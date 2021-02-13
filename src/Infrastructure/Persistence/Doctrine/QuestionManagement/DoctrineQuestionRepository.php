<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Persistence\Doctrine\QuestionManagement;

use App\Domain\Exception\EntityNotFound;
use App\Domain\QuestionManagement\Question;
use App\Domain\QuestionManagement\Question\QuestionId;
use App\Domain\QuestionManagement\QuestionsRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;

/**
 * DoctrineAnswerRepository
 *
 * @package App\Infrastructure\Persistence\Doctrine\QuestionManagement
 */
final class DoctrineQuestionRepository implements QuestionsRepository
{
    /**
     * @var EntityManagerInterface|EntityManager
     */
    private EntityManagerInterface $entityManager;

    /**
     * Creates a DoctrineAnswerRepository
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Adds a question to the questions repository
     *
     * @param Question $question
     * @return Question
     * @throws ORMException
     */
    public function add(Question $question): Question
    {
        $this->entityManager->persist($question);
        $this->entityManager->flush();
        return $question;
    }

    /**
     * Retrieves the question stored with provided identifier
     *
     * @param QuestionId $questionId
     * @return Question
     * @throws EntityNotFound when no question is found for provided identifier
     * @throws ORMException
     */
    public function withId(QuestionId $questionId): Question
    {
        $question = $this->entityManager->find(Question::class, $questionId);
        if ($question instanceof Question) {
            return $question;
        }

        throw new EntityNotFound(
            "Tag with ID '{$questionId}' was not found in this server."
        );
    }

    /**
     * Updates changes on provided question
     *
     * @param Question $question
     * @return Question
     * @throws ORMException
     */
    public function update(Question $question): Question
    {
        $this->entityManager->flush($question);
        return $question;
    }

    /**
     * Remove provided question from repository
     *
     * @param Question $question
     */
    public function remove(Question $question): void
    {
        $this->entityManager->remove($question);
        $this->entityManager->flush();
    }
}