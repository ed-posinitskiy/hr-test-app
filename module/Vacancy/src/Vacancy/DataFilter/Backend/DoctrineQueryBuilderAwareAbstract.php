<?php

namespace Vacancy\DataFilter\Backend;

use Vacancy\DataFilter\BackendInterface;
use Vacancy\DataFilter\Filter;
use Doctrine\ORM\QueryBuilder;

/**
 * Abstract implementation of BackendInterface which is not implement main BackendInterface::filter() method.
 * It only sets methods to work with doctrine query builder for DB data filtration, so client classes could know, can the
 * pass doctrine query builder to the filter backend
 *
 * @package Vacancy\DataFilter\Backend
 */
abstract class DoctrineQueryBuilderAwareAbstract implements BackendInterface {

    /**
     * @var QueryBuilder
     */
    protected $queryBuilder;

    /**
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     *
     * @return $this
     */
    public function setQueryBuilder(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
        return $this;
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }

    abstract public function filter(Filter $filter);

} 