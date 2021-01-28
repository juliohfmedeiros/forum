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

        $pagination = new Pagination($this->getTotalRows($queryBuilder), 10);


        $queryBuilder
            ->select("q.id as questionId, q.title, q.body, q.open, u.name, q.applied_on as appliedOn")
            ->setFirstResult($pagination->firstResult())
            ->setMaxResults($pagination->maxResults());


        $stm = $this->connection->executeQuery($queryBuilder->getSQL());

        $result = new QueryResult($stm->fetchAllAssociative());
        $result->withPagination($pagination);
        return $result;
    }

    private function getTotalRows(QueryBuilder $queryBuilder)
    {
        $qb = clone $queryBuilder;
        $qb->select("count(*) as total");
        $result = $this->connection
            ->executeQuery(
                $qb->getSQL()
            )
            ->fetchOne();
        return (int) $result;
    }
}