<?php

namespace Translation\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Vacancy\Entity\Vacancy;
use Translation\Entity\Translation;

class LanguageRepository extends EntityRepository
{
    public function findAvailableLanguages(Vacancy $vacancy, Translation $except = null)
    {
        $qb = $this->createQueryBuilder('l');
        $expr = $qb->expr()->andX(
            $qb->expr()->eq('l.id', 't.language'),
            $qb->expr()->eq('t.vacancy', ':vacancy_id')
        );
        $qb->leftJoin('Translation\Entity\Translation', 't', Join::WITH, $expr);
        $qb->andWhere('t.id IS NULL');
        $qb->setParameter('vacancy_id', $vacancy->getId());

        if(isset($except)) {
            $qb->orWhere('t.id = :translation_id');
            $qb->setParameter('translation_id', $except->getId());
        }

        $languages = $qb->getQuery()->getResult();
        return $languages;
    }
} 