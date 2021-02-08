<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Persistence\Doctrine\QuestionManagement\Question;

use App\Application\Pagination;
use App\Application\QueryResult;
use App\Application\QuestionManagement\QuestionsListQuery;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\Exception as DBALException;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * DoctrineQuestionsListQuery
 *
 * @package App\Infrastructure\Persistence\Doctrine\QuestionManagement\Question
 */
final class DoctrineQuestionsListQuery implements QuestionsListQuery
{

    /**
     * @var Connection
     */
    private $connection;

    /**
     * DoctrineQuestionsQuery constructor.
     * @param Connection|\Doctrine\DBAL\Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }


    /**
     * Returns a query result for provided attribute list
     *
     * @param array $attributes
     *
     * @return QueryResult
     */
    public function data(array $attributes = []): QueryResult
    {
        $queryBuilder = $this->connection->createQueryBuilder()
            ->from("questions", "q")
            ->leftJoin("q", "users", "u", "u.id = q.owner_id");

        $this->checkOwnerClause($attributes, $queryBuilder);
        $this->checkPatternFilter($attributes, $queryBuilder);

        $pagination = (
            new Pagination($this->getTotalRows($queryBuilder), $attributes['rows'])
        )
            ->forPage($attributes["page"]);

        $queryBuilder
            ->select("q.id as questionId, q.title, q.body, q.open, u.id as ownerId, q.applied_on as appliedOn, u.name as ownerName, u.email as ownerEmail")
            ->setFirstResult($pagination->firstResult())
            ->setMaxResults($pagination->maxResults());


        $stm = $queryBuilder->execute();

        $result = new QueryResult($stm->fetchAllAssociative());
        $this->updateAttributes(['pattern', 'page', 'rows'], $attributes, $result);
        $result->withPagination($pagination);
        return $result;
    }

    /**
     * Executes the filtered query to retrieve the total rows
     *
     * @param QueryBuilder $queryBuilder
     * @return int
     * @throws DBALException
     */
    private function getTotalRows(QueryBuilder $queryBuilder)
    {
        $qb = clone $queryBuilder;
        $qb->select("count(*) as total");
        $result = $qb->execute()->fetchOne();
        return (int) $result;
    }

    /**
     * Adds the owner ID in query filter
     *
     * @param array $attributes
     * @param QueryBuilder $queryBuilder
     */
    private function checkOwnerClause(array $attributes, QueryBuilder $queryBuilder)
    {
        if (!array_key_exists("ownerId", $attributes)) {
            return;
        }

        $queryBuilder->where("q.owner_id = :ownerId");
        $queryBuilder->setParameter('ownerId', $attributes['ownerId']);
    }

    /**
     * Adds search pattern filter
     *
     * @param array        $attributes
     * @param QueryBuilder $builder
     */
    private function checkPatternFilter(array $attributes, QueryBuilder $builder)
    {
        if (!array_key_exists('pattern', $attributes) || $attributes['pattern'] == null) {
            return;
        }

        $builder
            //->where('q.tags LIKE :pattern')
            ->where('q.title LIKE :pattern')
            ->orWhere('u.email LIKE :pattern')
            ->orWhere('u.name LIKE :pattern')
            ->orWhere('q.body LIKE :pattern')

            ->setParameter('pattern', "%{$attributes['pattern']}%")
        ;
    }

    /**
     * Updates the query result attributes
     *
     * @param array $array
     * @param array $attributes
     * @param QueryResult $result
     */
    private function updateAttributes(array $array, array $attributes, QueryResult $result)
    {
        foreach ($array as $attribute) {
            if (array_key_exists($attribute, $attributes)) {
                $result->addAttribute($attribute, $attributes[$attribute]);
            }
        }
    }
}
