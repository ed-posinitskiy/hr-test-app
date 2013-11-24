<?php

namespace Translation\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Translation\Entity\Language;
use Vacancy\Entity\Vacancy;
use Translation\Entity\Translation;

class LanguageRepository extends EntityRepository
{
    /**
     * @var array
     */
    protected $config = array();

    /**
     * @param mixed $config
     *
     * @return $this
     */
    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Try to find all available languages for given Vacancy, which a not yet used for translation. If $except Translation
     * is set, than language of this Translation will bee in output array to.
     *
     * @param Vacancy     $vacancy
     * @param Translation $except
     *
     * @return array
     */
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

    /**
     * Try to find base language object by locale variable set in module config. If config is not set will throw an Exception
     *
     * @return null|Language
     * @throws \InvalidArgumentException
     */
    public function findBaseLanguage()
    {
        $baseLanguage = isset($this->config['base_language']) ? $this->config['base_language'] : array();
        if(!isset($baseLanguage['locale'])) {
            throw new \InvalidArgumentException('base_language config is not set');
        }

        $language = $this->findOneBy(array('locale' => $baseLanguage['locale']));
        return $language;
    }
} 