<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Persistence\Doctrine\AnswerManagement;

use App\Domain\Exception\EntityNotFound;
use App\Domain\AnswerManagement\Answer;
use App\Domain\AnswerManagement\Answer\AnswerId;
use App\Domain\AnswerManagement\AnswersRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;

/**
 * DoctrineAnswerRepository
 *
 * @package App\Infrastructure\Persistence\Doctrine\AnswerManagement
 */
final class DoctrineAnswerRepository implements AnswersRepository
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
     * Adds a answer to the answers repository
     *
     * @param Answer $answer
     * @return Answer
     * @throws ORMException
     */
    public function add(Answer $answer): Answer
    {
        $this->entityManager->persist($answer);
        $this->entityManager->flush();
        return $answer;
    }

    /**
     * Retrieves the answer stored with provided identifier
     *
     * @param AnswerId $answerId
     * @return Answer
     * @throws EntityNotFound when no answer is found for provided identifier
     * @throws ORMException
     */
    public function withId(AnswerId $answerId): Answer
    {
        $answer = $this->entityManager->find(Answer::class, $answerId);
        if ($answer instanceof Answer) {
            return $answer;
        }

        throw new EntityNotFound(
            "Tag with ID '{$answerId}' was not found in this server."
        );
    }

    /**
     * Updates changes on provided answer
     *
     * @param Answer $answer
     * @return Answer
     * @throws ORMException
     */
    public function update(Answer $answer): Answer
    {
        $this->entityManager->flush($answer);
        return $answer;
    }

    /**
     * Remove provided answer from repository
     *
     * @param Answer $answer
     */
    public function remove(Answer $answer): void
    {
        $this->entityManager->remove($answer);
        $this->entityManager->flush();
    }
}