<?php

namespace Vacancy\DataFilter\Backend;

use Vacancy\DataFilter\Filter;
use Zend\Paginator\Paginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;

class DoctrinePaginationBackend extends DoctrineQueryBuilderAwareAbstract {

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
     * @return mixed
     */
    public function getPage()
    {
        if(!$this->page) {
            $this->page = 1;
        }
        return $this->page;
    }

    /**
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
     * @return mixed
     */
    public function getPerPage()
    {
        if(!$this->perPage) {
            $this->perPage = static::DEFAULT_PER_PAGE;
        }
        return $this->perPage;
    }

    /**
     * @return \Zend\Paginator\Paginator
     */
    public function getPaginator()
    {
        return $this->paginator;
    }

    public function filter(Filter $filter)
    {
        $qb = $this->getQueryBuilder();
        if(isset($qb)) {
            $query = $qb->getQuery();
            $paginator = new Paginator(new DoctrinePaginator(new ORMPaginator($query)));
            $paginator->setCurrentPageNumber($this->getPage());
            $paginator->setItemCountPerPage($this->getPerPage());
            $this->paginator = $paginator;
        }

        return $this;
    }

} 