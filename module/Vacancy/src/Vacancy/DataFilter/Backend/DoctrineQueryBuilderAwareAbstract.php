<?php

namespace Vacancy\DataFilter\Backend;

use Vacancy\DataFilter\BackendInterface;
use Vacancy\DataFilter\Filter;
use Doctrine\ORM\QueryBuilder;

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