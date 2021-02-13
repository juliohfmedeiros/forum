<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Persistence\Doctrine\TagManagement\Tag;

use App\Application\Pagination;
use App\Application\QueryResult;
use App\Application\TagManagement\TagsListQuery;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\Exception as DBALException;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * DoctrineTagsListQuery
 *
 * @package App\Infrastructure\Persistence\Doctrine\TagManagement\Tag
 */
final class DoctrineTagsListQuery implements TagsListQuery
{

    /**
     * @var Connection
     */
    private $connection;

    /**
     * DoctrineAnswerQuery constructor.
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
            ->from("tags", "t")
            ->leftJoin("t", "users", "u");


        $pagination = (
            new Pagination($this->getTotalRows($queryBuilder), $attributes['rows'])
        )
            ->forPage($attributes["page"]);

        $queryBuilder
            ->select("q.id as answerId, q.description, q.accepted, u.id as ownerId, q.given_on as givenOn, u.name as ownerName, u.email as ownerEmail")
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
            ->where('q.description LIKE :pattern')
            ->orWhere('u.email LIKE :pattern')
            ->orWhere('u.name LIKE :pattern')

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
