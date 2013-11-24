<?php

namespace Vacancy\DataFilter\Backend;

/**
 * Base abstract class which is not implements filter() method. It has common methods for extending by specific backends
 *
 * @package Vacancy\DataFilter\Backend
 */
abstract class VacancyFilterBackendAbstract extends DoctrineQueryBuilderAwareAbstract {

    const EXPR_EQ = '=';
    const EXPR_NEQ = '!=';

    /**
     * SQL expression (see class constants)
     *
     * @var string
     */
    protected $expr;

    /**
     * Value name (key) in Filter object which is corresponds to this backend (operation)
     *
     * @var string
     */
    protected $filterVar;

    /**
     * Variable name (or alias) in Doctrine QueryBuilder which should be filtered
     *
     * @var string
     */
    protected $queryVar;

    public function __construct($filterVar, $queryVar, $expr = self::EXPR_EQ)
    {
        $this->setFilterVar($filterVar);
        $this->setQueryVar($queryVar);
        $this->setExpr((isset($expr)) ? $expr : self::EXPR_EQ);
    }

    /**
     * Sets filter variable name
     *
     * @param mixed $filterVar
     *
     * @return $this
     */
    public function setFilterVar($filterVar)
    {
        $this->filterVar = $filterVar;
        return $this;
    }

    /**
     * Returns filter variable name
     *
     * @return mixed
     */
    public function getFilterVar()
    {
        return $this->filterVar;
    }

    /**
     * Sets QueryBuilder variable name (alias)
     *
     * @param mixed $queryVar
     *
     * @return $this
     */
    public function setQueryVar($queryVar)
    {
        $this->queryVar = $queryVar;
        return $this;
    }

    /**
     * Returns QueryBuilder variable name (alias)
     *
     * @return mixed
     */
    public function getQueryVar()
    {
        return $this->queryVar;
    }

    /**
     * Sets SQL expression
     *
     * @param mixed $expr
     *
     * @return $this
     */
    public function setExpr($expr)
    {
        $this->expr = $expr;
        return $this;
    }

    /**
     * Returns SQL expression
     *
     * @return mixed
     */
    public function getExpr()
    {
        return $this->expr;
    }

} 