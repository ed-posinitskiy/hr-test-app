<?php

namespace Vacancy\Repository;

use Doctrine\ORM\EntityRepository;
use Vacancy\DataFilter\Backend\DoctrinePaginationBackend;
use Vacancy\DataFilter\Backend\DoctrineQueryBuilderAwareAbstract;
use Vacancy\DataFilter\Filter;

class VacancyRepository extends EntityRepository
{

    public function findByFilterNested(Filter $filter = null)
    {
        $qb = $this->createQueryBuilder('v');
        $qb->select(array('v', 'd', 't', 'l'));
        $qb->innerJoin('v.department', 'd');
        $qb->leftJoin('v.translations', 't');
        $qb->leftJoin('t.language', 'l');

        if(isset($filter)) {
            $backends = $filter->getBackends();
            foreach($backends as $backend) {
                if($backend instanceof DoctrineQueryBuilderAwareAbstract) {
                    $backend->setQueryBuilder($qb);
                }

                if($backend instanceof DoctrinePaginationBackend) {
                    $paginationBackend = $backend;
                }
            }
            $filter->filter();
        }

        if(isset($paginationBackend)) {
            return $paginationBackend->getPaginator();
        } else {
            return $qb->getQuery()->getResult();
        }
    }

} 