<?php

namespace Vacancy\DataFilter\Backend;

use Vacancy\DataFilter\Filter;

class VacancyFilterBackend extends DoctrineQueryBuilderAwareAbstract {

    const EXPR_EQ = '=';
    const EXPR_NEQ = '!=';

    /**
     * @var array
     */
    protected $pairs = array();

    /**
     * @var string
     */
    protected $expr;

    public function __construct($filterValues = array(), $expr = self::EXPR_EQ)
    {
        if(!empty($filterValues)) {
            $this->_pairs = $filterValues;
        }

        $this->setExpr((isset($expr)) ? $expr : self::EXPR_EQ);
    }

    /**
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
     * @return mixed
     */
    public function getExpr()
    {
        return $this->expr;
    }

    public function filter(Filter $filter)
    {
        foreach($this->pairs as $inputValue => $queryAlias) {
            $this->_doFilter($filter, $inputValue, $queryAlias);
        }
    }

    /**
     * @param string $inputName
     * @param string $queryAlias
     *
     * @return $this
     */
    public function setQueryAlias($inputName, $queryAlias)
    {
        $this->pairs[$inputName] = $queryAlias;
        return $this;
    }

    /**
     * @param $name
     *
     * @return null
     */
    public function getQueryAlias($name)
    {
        return isset($this->pairs[$name]) ? $this->pairs[$name] : null;
    }

    protected function _doFilter(Filter $filter, $inputName, $queryAlias = null)
    {
        $value = $filter->getValue($inputName);
        $queryValue = isset($queryAlias) ? $queryAlias : $this->getQueryAlias($inputName);
        $qb = $this->getQueryBuilder();
        if($value && isset($qb) && isset($queryValue)) {
            $paramName = uniqid($inputName . '_');
            $qb->andWhere($queryValue . ' ' . $this->getExpr() . ' :' . $paramName);
            $qb->setParameter($paramName, $value);
        }

        return $this;
    }

} 