<?php

namespace Vacancy\Hydrator\Strategy;

use Department\Entity\Department;
use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

use Doctrine\ORM\EntityManager;

/**
 * Class DepartmentValueStrategy implements Zend\Stdlib\Hydrator\Strategy\StrategyInterface
 * This class should be used for proper hydration of \Vacancy\Entity\Vacancy::department property
 * It realizes zend hydration strategy interface and can be attached to any hydrator, which implements
 * \Zend\Stdlib\Hydrator\Strategy\StrategyEnabledInterface
 *
 * @package Vacancy\Hydrator\Strategy
 */
class DepartmentValueStrategy implements StrategyInterface
{

    /**
     * @var EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->setEm($em);
    }

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

    /**
     * Converts the given value so that it can be extracted by the hydrator.
     *
     * @param \Department\Entity\Department $value The original value.
     *
     * @return mixed Returns the value that should be extracted.
     * @throws \InvalidArgumentException if given value is not instance of \Department\Entity\Department
     */
    public function extract($value)
    {
        if (!$value instanceof Department) {
            throw new \InvalidArgumentException('Given value must be instance of \Department\Entity\Department');
        }

        return $value->getId();
    }

    /**
     * Converts the given value so that it can be hydrated by the hydrator.
     *
     * @param mixed $value The original value.
     *
     * @return \Department\Entity\Department Returns the value that should be hydrated.
     * @throws \InvalidArgumentException Throws exception if \Doctrine\ORM\EntityManager is not set
     */
    public function hydrate($value)
    {
        if (!isset($this->em)) {
            throw new \InvalidArgumentException('\Doctrine\ORM\EntityManager is not set');
        }

        $department = $this->getEm()->find('Department\Entity\Department', $value);
        return $department;
    }

} 