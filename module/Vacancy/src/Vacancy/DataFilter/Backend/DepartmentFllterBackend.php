<?php

namespace Vacancy\DataFilter\Backend;

use Vacancy\DataFilter\Filter;

/**
 * Adds filtered values to QueryBuilder via its respective API
 *
 * @package Vacancy\DataFilter\Backend
 */
class DepartmentFllterBackend extends VacancyFilterBackendAbstract
{

    /**
     * If QueryBuilder object is set and filter respective value is not empty, add query parameters to Doctrine
     * QueryBuilder object
     *
     * @param Filter $filter
     *
     * @return $this
     */
    public function filter(Filter $filter)
    {
        $qb = $this->getQueryBuilder();
        $value = $filter->getValue($this->getFilterVar());
        if(isset($qb) && $value) {
            $paramName = uniqid($this->getFilterVar() . '_');
            $qb->andWhere($this->getQueryVar() . ' ' . $this->getExpr() . ' :' . $paramName);
            $qb->setParameter($paramName, $value);
        }

        return $this;
    }

} 