<?php

namespace Vacancy\DataFilter\Backend;

use Vacancy\DataFilter\Filter;

/**
 * Adds filtered values from Filter to QueryBuilder via its respective API
 *
 * @package Vacancy\DataFilter\Backend
 */
class LanguageFilterBackend extends VacancyFilterBackendAbstract
{

    /**
     * Module configuration array
     *
     * @var array
     */
    protected $config = array();

    /**
     * Sets module configuration array
     *
     * @param array $config
     *
     * @return $this
     */
    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * Returns module configuration array
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Check if the base_language['locale'] value is set in config or if respective filter value is not empty and if it so
     * add query parameters to Doctrine QueryBuilder object
     *
     * @param Filter $filter
     *
     * @return $this
     */
    public function filter(Filter $filter)
    {
        $config = $this->getConfig();
        $baseLanguage = isset($config['base_language']['locale']) ? $config['base_language']['locale'] : null;

        $qb = $this->getQueryBuilder();
        $value = $filter->getValue($this->getFilterVar());
        if (isset($qb) && ($value || $baseLanguage)) {
            $paramName = uniqid($this->getFilterVar() . '_');

            $sql = $this->getExpr() . ' :' . $paramName;
            if(isset($baseLanguage) && $baseLanguage != $value) {
                $value = ($value) ? array($baseLanguage, $value) : array($baseLanguage);
                $sql = 'IN (:' . $paramName . ')';
            }

            $qb->andWhere($this->getQueryVar() . ' ' . $sql);
            $qb->setParameter($paramName, $value);
        }

        return $this;
    }

} 