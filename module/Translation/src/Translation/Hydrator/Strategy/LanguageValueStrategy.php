<?php

namespace Translation\Hydrator\Strategy;

use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;
use Doctrine\ORM\EntityManager;
use Translation\Entity\Language;

/**
 * Class LanguageValueStrategy implements Zend\Stdlib\Hydrator\Strategy\StrategyInterface
 * This class should be used for proper hydration of \Translation\Entity\Translation::language property
 * It realizes Zend hydration strategy interface and can be attached to any hydrator, which implements
 * \Zend\Stdlib\Hydrator\Strategy\StrategyEnabledInterface
 *
 * @package Translation\Hydrator\Strategy
 */
class LanguageValueStrategy implements StrategyInterface
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @param \Doctrine\ORM\EntityManager $em
     *
     * @return $this
     */
    public function setEm(EntityManager $em)
    {
        $this->em = $em;
        return $this;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEm()
    {
        return $this->em;
    }

    public function __construct(EntityManager $em)
    {
        $this->setEm($em);
    }

    /**
     * Converts the given value so that it can be extracted by the hydrator.
     *
     * @param \Translation\Entity\Language $value The original value.
     *
     * @return mixed Returns the value that should be extracted.
     * @throws \InvalidArgumentException
     */
    public function extract($value)
    {
        if(!$value instanceof Language) {
            throw new \InvalidArgumentException('Given value must be instance of \Translation\Entity\Language');
        }

        return $value->getId();
    }

    /**
     * Converts the given value so that it can be hydrated by the hydrator.
     *
     * @param mixed $value The original value.
     *
     * @return \Translation\Entity\Language Returns the value that should be hydrated.
     * @throws \InvalidArgumentException
     */
    public function hydrate($value)
    {
        if (!isset($this->em)) {
            throw new \InvalidArgumentException('\Doctrine\ORM\EntityManager is not set');
        }

        $language = $this->getEm()->find('Translation\Entity\Language', $value);
        return $language;
    }


} 