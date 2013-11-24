<?php

namespace Vacancy\DataFilter\Backend;

use Vacancy\DataFilter\Filter;
use Zend\Paginator\Paginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;

/**
 * Zend Pagination with Doctrine ORM Pagination filter. Creates instance of Zend\Paginator\Paginator using given
 * Doctrine QueryBuilder object to get Doctrine Query object
 *
 * @package Vacancy\DataFilter\Backend
 */
class DoctrinePaginationBackend extends DoctrineQueryBuilderAwareAbstract
{

    const DEFAULT_PER_PAGE = 10;

    /**
     * @var int
     */
    protected $page;

    /**
     * @var int
     */
    protected $perPage;

    /**
     * @var Paginator
     */
    protected $paginator;

    public function __construct($page = 1, $perPage = self::DEFAULT_PER_PAGE)
    {
        $this->setPage(($page) ? : 1);
        $this->setPerPage(($perPage) ? : self::DEFAULT_PER_PAGE);
    }

    /**
     * Set current page number
     *
     * @param mixed $page
     *
     * @return $this
     */
    public function setPage($page)
    {
        $this->page = $page;
        return $this;
    }

    /**
     * Returns current page number
     *
     * @return mixed
     */
    public function getPage()
    {
        if (!$this->page) {
            $this->page = 1;
        }
        return $this->page;
    }

    /**
     * Set number of items per page
     *
     * @param mixed $perPage
     *
     * @return $this
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }

    /**
     * Returns number of items per page
     *
     * @return mixed
     */
    public function getPerPage()
    {
        if (!$this->perPage) {
            $this->perPage = static::DEFAULT_PER_PAGE;
        }
        return $this->perPage;
    }

    /**
     * Returns instantiated Paginator object or null if it's not created yet
     *
     * @return \Zend\Paginator\Paginator
     */
    public function getPaginator()
    {
        return $this->paginator;
    }

    /**
     * If the QuieryBuilder object is set, creates Zend\Paginator\Pagination object with DoctrinePaginator adapter, sets
     * up current page and number of items per page.
     *
     * @param Filter $filter
     *
     * @return $this
     */
    public function filter(Filter $filter)
    {
        $qb = $this->getQueryBuilder();
        if (isset($qb)) {
            $query = $qb->getQuery();
            $paginator = new Paginator(new DoctrinePaginator(new ORMPaginator($query)));
            $paginator->setCurrentPageNumber($this->getPage());
            $paginator->setItemCountPerPage($this->getPerPage());
            $this->paginator = $paginator;
        }

        return $this;
    }

} 